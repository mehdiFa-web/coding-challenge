<?php

namespace App\Http\Controllers;

use App\Exceptions\UnableToCreateCategoryException;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $result = [
            'status' => 200,
        ];
        try {
            $result['data'] = $this->categoryService->get();
        }catch (\Exception $exception) {
            $result['status'] = 404;
        }
        return response()->json($result,$result['status']);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            "name" => ["required"],
            "parent_id" => ["nullable","numeric"]
        ]);
        $result = [
          'status' => 201,
          'saved' => true,
            'errors' => []
        ];
        try {
            $this->categoryService->create($validated);
        }catch (UnableToCreateCategoryException $exception) {
            $result['errors'] = ['unable to new category'];
            $result['saved']  = false;
            $result['status'] = 409;
        }
        return response()->json($result,$result['status']);
    }
}
