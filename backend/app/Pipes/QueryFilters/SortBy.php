<?php

namespace App\Pipes\QueryFilters;


use App\Dto\ProductFilteringData;

class SortBy
{
    public function handle(ProductFilteringData $filteringData,\Closure $next)
    {
        if( ! $filteringData->queries->has('sortBy') ) {
            return $next($filteringData);
        }
        $sortingOptions = [
            "lth" => "asc",
            "htl" => "desc" ,
            "name" => "asc"
        ];
        if( $filteringData->queries->get("sortBy") !== "name") {
            $filteringData->productQuery->orderBy('price',$sortingOptions[$filteringData->queries->get('sortBy')] ?? "asc");
            return $next($filteringData);
        }

        $filteringData->productQuery->orderBy('name');
        return $next($filteringData);
    }
}
