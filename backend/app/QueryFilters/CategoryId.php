<?php

namespace App\QueryFilters;

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

    public function handle(Builder $builder,\Closure $next)
    {
        if( ! \request()->has('category_id') ) {
            return $next($builder);
        }
        $categories = $this->categoryRepository->findWithDescendants(\request()->input('category_id'));
        return $next(
            $builder->whereHas('categories', function (Builder $query) use ($categories) {
                $query->whereIn('category_id', $categories);
            })
        );
    }
}
