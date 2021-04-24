<?php


namespace App\Repositories;


use App\Dto\ProductData;
use App\Dto\ProductFilteringData;
use App\Models\Product;
use App\Pipes\QueryFilters\CategoryId;
use App\Pipes\QueryFilters\SortBy;
use App\Pipes\UpdateProduct\UpdateDescription;
use App\Pipes\UpdateProduct\UpdateImage;
use App\Pipes\UpdateProduct\UpdateName;
use App\Pipes\UpdateProduct\UpdatePrice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pipeline\Pipeline;

class ProductRepository
{
    /**
     * @var Product|null
     */
    private $savedProduct;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Collection
     */
    private $registeredModels;

    /**
     * ProductRepository constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->registeredModels = collect([]);
    }

    public function getProductsWithFilters(ProductFilteringData $productDataParam)
    {
        /**
         * @var Pipeline $pipeline
         * */
        $pipeline = resolve(Pipeline::class);
        /**
         * @var ProductFilteringData $productData
         * */
        $productData = $pipeline->send($productDataParam)
            ->through([
                SortBy::class ,
                CategoryId::class
            ])->thenReturn();
        return $productData->productQuery->get();
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return Product::first();
    }


    /**
     * @param string $relation
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function firstWith(string $relation)
    {
        return Product::with($relation)->first();
    }

    /**
     * @param array $data
     * @return ProductRepository
     */
    public function store(array $data): ProductRepository
    {
        $product = new Product;
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->image = $data['image'];
        $product->save();
        $this->savedProduct = $product->fresh();
        return $this;
    }

    public function attach(array $category_ids)
    {
        $categories = $this->categoryRepository->find($category_ids);
        $this->savedProduct->categories()->sync($categories);
    }

    public function query()
    {
        return Product::query();
    }

    /**
     * @param int $id
     * @return Model|Collection|Builder
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        return Product::findOrFail($id);
    }

    public function update(ProductData $productData): bool
    {
        /** @var Pipeline $pipeline **/
        $pipeline = resolve(Pipeline::class);
        /** @var ProductData $updatedProduct **/
        $updatedProduct = $pipeline->send($productData)->through([
            UpdateImage::class,
            UpdateDescription::class,
            UpdatePrice::class,
            UpdateName::class,
        ])->thenReturn();
        if( ! $updatedProduct->product->save()) {
            throw new \Exception("Product is not updated");
        }
        return true;
    }

    public function destroy(int $id = null): bool
    {
        if( ! $id && $this->registeredModels->count()) {
            /**
             * @var Product $product
             * */
            $product = $this->registeredModels->first();
            $this->unregisterModels();
            return $product->delete();
        }

        $product = $this->find($id);
        return $product->delete();
    }

    public function findThenRegister(int $id)
    {
        $this->registeredModels->push($this->find($id));
    }

    public function getInfoBeforeDelete() : array
    {
        $productInfo = $this->registeredModels->map(function (Product $product){
            return [
              "image" => $product->image
            ];
        });
        return $productInfo[0];
    }

    private function unregisterModels()
    {
        $this->registeredModels = collect([]);
    }

}
