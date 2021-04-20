<?php


namespace App\Repositories;


use App\Models\Category;
use App\Models\Product;
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
     * ProductRepository constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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

    public function update(int $id)
    {
        /** @var Pipeline $pipeline **/
        $pipeline = resolve(Pipeline::class);
        $updatedProduct = $pipeline->send($this->find($id))->through([
            UpdateImage::class,
            UpdateDescription::class,
            UpdatePrice::class,
            UpdateName::class,
        ])->thenReturn();
        if( ! $updatedProduct->save()) {
            throw new \Exception("Product is not updated");
        }
    }

}
