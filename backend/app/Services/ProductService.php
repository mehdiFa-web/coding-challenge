<?php


namespace App\Services;



use App\Dto\ProductData;
use App\Dto\ProductFilteringData;
use App\Pipes\QueryFilters\CategoryId;
use App\Pipes\QueryFilters\SortBy;
use App\Repositories\ProductRepository;
use Exception;
use Illuminate\Pipeline\Pipeline;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
    public function get()
    {
        //
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function update(array $data, int $id): bool
    {
        return $this->productRepository->update(new ProductData([
            "requestDTO" => collect($data),
            'product' => $this->productRepository->find($id)
        ]));
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $this->productRepository->findThenRegister($id);
        $imageName = $this->productRepository->getInfoBeforeDelete()['image'];

        if( ! $this->productRepository->destroy($id) ) {
            throw new Exception("Something goes wrong. you can't delete product");
        }

        $this->fileHandlerService->destroy("/images/products/".$imageName);
        return true;
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

    /**
     * @throws UnknownProperties
     */
    public function getWithSorting(array $arrayOfQueries)
    {
        return $this->productRepository->getProductsWithFilters((new ProductFilteringData([
            'productQuery' => $this->productRepository->query(),
            'queries' => collect($arrayOfQueries)
        ])));
    }
}
