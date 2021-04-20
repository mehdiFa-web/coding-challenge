<?php

namespace App\Console\Commands;

use App\Exceptions\UnableToCreateCategoryException;
use App\Services\CategoryService;
use Illuminate\Console\Command;

class DeleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a category by id';
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }


    public function handle()
    {
        $this->warn('all children of category you want to delete will be deleted');
        $id = $this->ask('What is the id of the Category?');
        $message = "Category is deleted";

        try {
            $this->categoryService->delete($id);
        }catch (\Exception $exception) {
            $message = "Unable to delete new category";
        }

        $this->info($message);
    }
}
