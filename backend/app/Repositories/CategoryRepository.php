<?php


namespace App\Repositories;


use App\Models\Category;

class CategoryRepository
{
    public function store(array $data): bool
    {
        $category = new Category;
        $category->name = $data['name'];
        $category->parent_id = $data['parent_id'] ?? null;
        return $category->save();
    }
}
