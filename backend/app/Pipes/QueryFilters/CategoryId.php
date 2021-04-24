<?php

namespace App\Pipes\QueryFilters;

use App\Dto\ProductFilteringData;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Builder;

class CategoryId
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(ProductFilteringData $filteringData,\Closure $next)
    {
        if( !$filteringData->queries->has('category_id') ) {
            return $next($filteringData);
        }
        $categories = $this->categoryRepository->findWithDescendants($filteringData->queries->get('category_id'));

        $filteringData->productQuery->whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('category_id', $categories);
        });

        return $next($filteringData);
    }
}
