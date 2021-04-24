<?php


namespace App\Dto;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class ProductData extends DataTransferObject
{
    /**
     * @var Collection $requestDTO
     * */
    public $requestDTO;

    /**
     * @var Model $product
     * */
    public $product;
}
