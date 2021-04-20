<?php

namespace App\Console\Commands;

use App\Services\ProductService;
use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'you can delete products with this command';
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
        $id = $this->ask('What is the name of the Product?');

        $message = "Product is deleted";
        try {
            $this->productService->delete($id);
        }catch (\Exception $exception) {
            $message = "Unable to create new Product";
        }

        $this->info($message);
    }
}
