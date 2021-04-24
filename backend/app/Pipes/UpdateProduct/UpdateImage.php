<?php


namespace App\Pipes\UpdateProduct;


use App\Dto\ProductData;
use App\Exceptions\UnableToSaveFile;
use App\Services\FileHandlerService;

class UpdateImage
{
    /**
     * @var FileHandlerService
     */
    private $fileHandlerService;

    /**
     * UpdateImage constructor.
     * @param FileHandlerService $fileHandlerService
     */
    public function __construct(FileHandlerService $fileHandlerService)
    {
        $this->fileHandlerService = $fileHandlerService;
    }

    /**
     * @throws UnableToSaveFile
     */
    public function handle(ProductData $productData, \Closure $next)
    {
        if( ! $productData->requestDTO->has("image") ) {
            return $next($productData);
        }

        // delete old file
        $this->fileHandlerService->destroy("/images/products/".$productData->product->image);
        // upload new file
        $productData->product->image = $this->fileHandlerService->upload($productData->requestDTO->get("image"),"/images/products");
        return $next($productData);
    }
}
