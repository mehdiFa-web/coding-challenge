<?php

namespace App\Console\Commands;

use App\Exceptions\UnableToCreateCategoryException;
use App\Services\CategoryService;
use Illuminate\Console\Command;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'You can create new categories with this command';
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
        $name = $this->ask('What is the name of the Category?');
        $parentId = $this->ask('What is the parent id of the Category? : leave blank for null');
        $message = "Category created with success";
        try {
            $this->categoryService->create([
                "name" => $name ,
                "parent_id" => $parentId
            ]);
        }catch (UnableToCreateCategoryException $exception) {
            $message = "Unable to create new category";
        }

        $this->info($message);
    }
}
