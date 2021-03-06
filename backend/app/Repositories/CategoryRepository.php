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
     * @param mixed $id
     * @return Model|Collection
     * @throws ModelNotFoundException
     */
    public function find($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Return a collection of current category id and also list of descendants ids
     * @param int $categoryId
     * @return mixed
     */
    public function findWithDescendants(int $categoryId)
    {
        $category = $this->find($categoryId);
        $categories = $category->descendants()->pluck('id');
        // Include the id of category itself
        $categories[] = $category->getKey();
        return $categories;
    }

    /**
     * @param int $id
     */
    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->find($id);
        $category->name = $data['name'];
        return $category->save();
    }
}
