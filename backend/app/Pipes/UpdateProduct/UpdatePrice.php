<?php


namespace App\Pipes\UpdateProduct;


use Illuminate\Database\Eloquent\Model;

class UpdatePrice
{
    public function handle(Model $product, \Closure $next)
    {
        if( ! request()->has('price') ) {
            return $next($product);
        }

        $product->name = request()->get('price');
        return $next($product);
    }
}
