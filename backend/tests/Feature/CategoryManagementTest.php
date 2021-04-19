<?php

namespace Tests\Feature;

use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = resolve(CategoryRepository::class);
    }

    /**
     * @test
     * */
    public function a_category_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route("categories.store"),[
           "name" => "smartphones"
        ]);
        $response->assertStatus(201);
        $this->assertCount(1,$this->categoryRepository->getAll());
    }
    /**
     * @test
     * */
    public function we_can_get_list_of_all_categories_in_a_form_of_tree_structure()
    {
        $this->postJson(route("categories.store"),[
            "name" => "smartphones"
        ]);
        $id = $this->categoryRepository->first()->id;
        $this->postJson(route("categories.store"),[
            "name" => "Mi",
            "parent_id" => $id
        ]);
        $this->postJson(route("categories.store"),[
            "name" => "Samsung",
            "parent_id" => $id
        ]);
        $response = $this->getJson(route("categories.index"));
        $response->assertStatus(200);
        $expectedContent = [
            [
                "name" => "smartphones",
                "id" => 2,
                "children" => [
                    [
                        "name" => "Mi",
                        "id" => 3,
                        "children" => []
                    ],
                    [
                        "name" => "Samsung",
                        "id" => 4,
                        "children" => []
                    ]
                ]
            ]
        ];
        $this->assertSame($expectedContent,$response->json('data'));
    }

    /**
     * @test
     */
    public function a_category_can_be_deleted()
    {
        $this->postJson(route("categories.store"),[
            "name" => "smartphones"
        ]);

        $response = $this->deleteJson(route("categories.destroy",[
            "id" => $this->categoryRepository->first()->id
        ]));

        $response->assertStatus(204);
        $this->assertCount(0,$this->categoryRepository->getAll());
    }
    /**
     * @test
     */
    public function when_a_category_deleted_children_also_will_be_deleted()
    {
        $this->postJson(route("categories.store"),[
            "name" => "smartphones"
        ]);
        $id = $this->categoryRepository->first()->id;
        $this->postJson(route("categories.store"),[
            "name" => "Mi",
            "parent_id" => $id
        ]);
        $this->postJson(route("categories.store"),[
            "name" => "Samsung",
            "parent_id" => $id
        ]);

        $response = $this->deleteJson(route("categories.destroy",[
            "id" => $id
        ]));

        $response->assertStatus(204);
        $this->assertCount(0,$this->categoryRepository->getAll());
    }

}
