<?php

namespace App\Pipes\UpdateProduct;

use App\Dto\ProductData;

class UpdateName
{
    public function handle(ProductData $productData, \Closure $next)
    {
        if( ! $productData->requestDTO->has('name') ) {
            return $next($productData);
        }

        $productData->product->name = $productData->requestDTO->get('name');
        return $next($productData);
    }
}
