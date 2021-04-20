<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'you can create new products with this command';

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $name = $this->ask('What is the name of the Product?');
        $description = $this->ask('What is the description of the Product?');
        $price = $this->ask('What is the price of the Product?');
        $categories = [];
        if ($this->confirm('Do you wish to add categories ?')) {
            $categoriesFromAsk = $this->ask('Add category ids separated with comma');
            $categories = explode(",", $categoriesFromAsk);
        }
        $message = "Product is created with success";
        try {
            $this->productService->create([
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "category_ids" => $categories,
                "image" => UploadedFile::fake()->image('image.jpg')
            ]);
        }catch (\Exception $exception) {
            $message = "Unable to create new Product";
        }

        $this->info($message);
    }
}
