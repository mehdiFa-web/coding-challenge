<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = [
            "status" => 200,
        ];
        try {
            /**
             * Sorting options :
             * Low to High
             * High to Low
             * Name
             * */
            $result["data"] = $this->productService->productsWithCategoryFilter();
        }catch (\Exception $e) {
            $result = [
                "status" => 401,
                "error" => $e->getMessage()
            ];
        }
        return response()->json($result,$result["status"]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            "name"        => ["required"],
            "description" => ["required"],
            "price"       =>["required","numeric"],
            "image"       => ["required","image"],
            "category_ids"=> ["array","nullable"],
            "category_ids.*" => ["numeric"]
        ]);
        $result = ["status"=>201];

        try {
            /*
             * creating product
             * saving image
             * attaching categories
             * */
            $this->productService->create($validated);
        }catch (\Exception $exception) {
            $result = [
                "status" =>409 ,
                "errors" => $exception->getMessage()
            ];
        }

        return response()->json($result,$result['status']);
    }
}
