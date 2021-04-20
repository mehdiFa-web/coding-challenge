<?php


namespace App\Pipes\UpdateProduct;


use App\Exceptions\UnableToSaveFile;
use App\Services\FileHandlerService;
use Illuminate\Database\Eloquent\Model;

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
    public function handle(Model $product, \Closure $next)
    {
        if( ! request()->has('image') ) {
            return $next($product);
        }

        // delete old file
        $this->fileHandlerService->destroy("/images/products/".$product->image);
        // upload new file
        $product->image =$this->fileHandlerService->upload(request()->file("image"),"/images/products");
        return $next($product);
    }
}
