<?php

namespace App\QueryFilters;

use Illuminate\Database\Query\Builder;

class SortBy
{
    public function handle(Builder $builder,\Closure $next)
    {
        if( ! \request()->has('sortBy') ) {
            return $next($builder);
        }
        $sortingOptions = [
            "lth" => "asc",
            "htl" => "desc" ,
            "name" => "asc"
        ];
        if( \request()->input("sortBy") !== "name") {
            return $next($builder->orderBy('price',$sortingOptions[\request()->input('sortBy')] ?? "asc"));
        }
        return $next($builder->orderBy('name'));
    }
}
