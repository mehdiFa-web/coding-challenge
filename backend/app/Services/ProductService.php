<?php


namespace App\Services;



use App\Pipes\QueryFilters\CategoryId;
use App\Pipes\QueryFilters\SortBy;
use App\Pipes\UpdateProduct\UpdateDescription;
use App\Pipes\UpdateProduct\UpdateImage;
use App\Pipes\UpdateProduct\UpdateName;
use App\Pipes\UpdateProduct\UpdatePrice;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Pipeline\Pipeline;

class ProductService implements ServiceInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var FileHandlerService
     * */
    private $fileHandlerService;

    /**
     * ProductService constructor.
     * @param ProductRepository $productRepository
     * @param FileHandlerService $fileHandlerService
     */
    public function __construct(ProductRepository $productRepository,FileHandlerService $fileHandlerService)
    {
        $this->productRepository = $productRepository;
        $this->fileHandlerService = $fileHandlerService;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->productsWithCategoryFilter();
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function updateProduct(int $id)
    {
        $this->productRepository->update($id);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        $fileName = $this->productRepository->destroy($id);
        $this->fileHandlerService->destroy("/images/products/".$fileName);
    }

    /**
     * @inheritDoc
     * @throws
     */
    public function create(array $data)
    {
        $category_ids = $data['category_ids'] ?? [];
        unset($data['category_ids']);
        $this->productRepository->store(array_merge($data,[
            "image" => $this->fileHandlerService->upload($data["image"],"/images/products")
        ]))->attach($category_ids);

    }

    public function productsWithCategoryFilter()
    {
        /**
         * @var Pipeline $pipeline
         * */
        $pipeline = resolve(Pipeline::class);
        $products = $pipeline->send($this->productRepository->query())->through([
            SortBy::class ,
            CategoryId::class
        ])->thenReturn();
        return $products->get();
    }
}
