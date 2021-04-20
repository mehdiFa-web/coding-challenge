<?php


namespace App\Pipes\UpdateProduct;


use Illuminate\Database\Eloquent\Model;

class UpdateDescription
{
    public function handle(Model $product, \Closure $next)
    {
        if( ! request()->has('description') ) {
            return $next($product);
        }

        $product->name = request()->get('description');
        return $next($product);
    }
}
