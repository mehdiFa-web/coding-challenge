<?php


namespace App\Dto;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class ProductFilteringData extends DataTransferObject
{
    /**
     * @var Builder
     */
    public $productQuery;

    /**
     * @var Collection
     */
    public $queries;
}
