<?php


namespace App\Pipes\UpdateProduct;


use Illuminate\Database\Eloquent\Model;

class UpdateName
{
    public function handle(Model $product, \Closure $next)
    {
        if( ! request()->has('name') ) {
            return $next($product);
        }

        $product->name = request()->get('name');
        return $next($product);
    }
}
