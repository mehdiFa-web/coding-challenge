<?php


namespace App\Services;


use App\Repositories\ProductRepository;

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
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        // TODO: Implement delete() method.
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
            "image" => $this->fileHandlerService->upload($data["image"],"images")
        ]))->attach($category_ids);

    }
}
