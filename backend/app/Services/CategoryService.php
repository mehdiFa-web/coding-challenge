<?php


namespace App\Services;


use App\Exceptions\UnableToCreateCategoryException;
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
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
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
