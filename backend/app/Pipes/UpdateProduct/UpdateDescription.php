<?php


namespace App\Pipes\UpdateProduct;


use App\Dto\ProductData;
use Illuminate\Database\Eloquent\Model;

class UpdateDescription
{
    public function handle(ProductData $productData, \Closure $next)
    {
        if( ! $productData->requestDTO->has('description') ) {
            return $next($productData);
        }

        $productData->product->description = $productData->requestDTO->get('description');
        return $next($productData);
    }
}
