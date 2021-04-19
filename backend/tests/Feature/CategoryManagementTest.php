<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;
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
        //$this->assertCount(1,);
    }
}
