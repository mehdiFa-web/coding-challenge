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
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->categoryRepository->toTree()->ToArray();
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): bool
    {
        return $this->categoryRepository->update($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
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

    public function flatList(): array
    {
        return $this->categoryRepository->getAll()->map(function($item) {
            return [
                "value" => $item->id,
                "label" => $item->name,
            ];
        })->toArray();
    }
}
