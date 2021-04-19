<?php


namespace App\Services;


use App\Exceptions\UnableToCreateCategoryException;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryService implements ServiceInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * recursive algorithm to build tree of categories each root category has children
     * @param $categories
     * @return array
     */
    private function traverse($categories): array
    {
        $result = [];
        $generate = function ($categories,&$result) use (&$generate) {
            foreach ($categories as $category) {
                $arr["name"] = $category->name;
                $arr["id"] = $category->id;
                $arr["children"] = [];
                $reference = &$arr["children"];
                $generate($category->children,$reference);
                array_push($result,$arr);
            }
        };
        $generate($categories,$result);
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->traverse($this->categoryRepository->toTree());
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id)
    {
        $this->categoryRepository->update($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id)
    {
        $this->categoryRepository->delete($id);
    }

    /**
     * @inheritDoc
     * @throws \Throwable
     */
    public function create(array $data)
    {
        $isCreated = $this->categoryRepository->store($data);
        throw_if(!$isCreated,new UnableToCreateCategoryException);
    }
}
