<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepository = app(ProductRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }

    /**
     * @test
     */
    public function a_product_can_be_created()
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('image.jpg');
        $response = $this->postJson(route("products.store"),[
            "name"        => "Set of two bob hats",
            "description" => "Beautiful black and white hats of good quality at good price",
            "price"       => 10.9,
            "image"       => $file
        ]);
        $response->assertStatus(201);
        Storage::disk()->assertExists("/images/products/".$file->hashName());

        $this->assertEquals("Set of two bob hats",$this->productRepository->first()->name);
    }

    /**
     * @test
     */
    public function a_category_can_be_attached_to_a_product()
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('image.jpg');
        $this->postJson(route("categories.store"),[
            "name" => "Samsung"
        ]);
        $id = $this->categoryRepository->first()->id;
        $response = $this->postJson(route("products.store"),[
            "name"        => "Set of two bob hats",
            "description" => "Beautiful black and white hats of good quality at good price",
            "price"       => 10.9,
            "image"       => $file,
            "category_ids" => [$id]
        ]);
        $response->assertStatus(201);
        $this->assertTrue($this->productRepository->firstWith('categories')->categories->contains("name",'Samsung'));
    }

    /**
     * @test
     */
    public function a_product_can_be_updated()
    {
        Storage::fake();
        $file = UploadedFile::fake()->image('image.jpg');
        $file2 = UploadedFile::fake()->image('image2.jpg');
        $this->postJson(route("categories.store"),[
            "name" => "Random"
        ]);
        $categoryId = $this->categoryRepository->first()->id;
        $this->postJson(route("products.store"),[
            "name"        => "Set of two bob hats",
            "description" => "Beautiful black and white hats of good quality at good price",
            "price"       => 10.9,
            "image"       => $file,
            "category_ids" => [$categoryId]
        ]);
        $productId = $this->productRepository->first()->id;

        $newData = [
            "name"        => "two bob hats",
            "description" => "Beautiful black and white hats of good quality at good price",
            "price"       => 10.9,
            "image"       => $file2,
            "category_ids" => [$categoryId]
        ];
        $response = $this->putJson(route("products.update",[
            "id" => $productId
        ]),$newData);

        $response->assertStatus(204);
        Storage::disk()->assertExists("/images/products/".$file2->hashName());
        Storage::disk()->assertMissing("/images/products/".$file->hashName());
        $this->assertEquals("two bob hats",$this->productRepository->first()->name);
        $this->assertEquals("Random",$this->productRepository->firstWith("categories")->categories->first()->name);
    }

    /**
     * @test
     * */
    public function a_product_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        Storage::fake();
        $file = UploadedFile::fake()->image('image.jpg');
        $this->postJson(route("products.store"),[
            "name"        => "Set of two bob hats",
            "description" => "Beautiful black and white hats of good quality at good price",
            "price"       => 10.9,
            "image"       => $file
        ]);

        $response = $this->deleteJson(route("products.destroy",[
            "id" => $this->productRepository->first()->id
        ]));
        $response->assertStatus(204);
        Storage::disk()->assertMissing("/images/products/".$file->hashName());

    }
}
