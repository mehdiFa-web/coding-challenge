<?php


namespace App\Pipes\UpdateProduct;


use App\Dto\ProductData;

class UpdatePrice
{
    public function handle(ProductData $productData, \Closure $next)
    {
        if( ! $productData->requestDTO->has('price') ) {
            return $next($productData);
        }

        $productData->product->price = $productData->requestDTO->get('price');
        return $next($productData);
    }
}
