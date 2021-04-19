<?php


namespace App\Repositories;


use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kalnoy\Nestedset\Collection;

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

    /**
     * @param int $id
     * @return Model|Collection
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        return Category::findOrFail($id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->find($id)->delete();
    }
}
