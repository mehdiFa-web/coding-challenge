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

    /**
     * return all categories
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Category::all();
    }

    public function toTree()
    {
        return Category::get()->toTree();
    }

    /**
     * return first category
     * @return mixed
     */
    public function first()
    {
        return Category::first();
    }
}
