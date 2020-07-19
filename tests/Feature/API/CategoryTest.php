<?php

namespace Tests\Feature\API;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_parent_category()
    {
        $this->withoutExceptionHandling();
        $category = ['name' => 'PHP', 'description' => 'This is a parent category'];

        $response = $this->json('POST', route('categories.store'), $category);

        $response->assertStatus(201);
        $response->assertHeader('Content-type', 'application/json');
        $response->assertJsonStructure(['name', 'description'])->assertJson($category);

        $this->assertDatabaseHas('categories', $category);
    }

    public function test_create_a_child_category()
    {
        $this->withoutExceptionHandling();
        $parent = factory(Category::class)->create();
        $category = [
            'name' => 'Laravel',
            'description' => 'Resources about this beautiful framework',
            'category_parent_id' => $parent->id
        ];

        $response = $this->json('POST', route('categories.store'), $category);
        $response->assertStatus(201);
        $response->assertHeader('Content-type', 'application/json');
        $response->assertJsonStructure(['name', 'description'])->assertJson($category);

        $this->assertDatabaseHas('categories', $category);
    }

    public function test_list_of_categories()
    {
        $this->withoutExceptionHandling();
        factory(Category::class, 50)->create();

        $response = $this->json('GET', route('categories.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['*' => [
            'name', 'description', 'category_parent_id'
        ]]]);
    }

    public function test_show_category_by_id()
    {
        $this->withoutExceptionHandling();
        $category = factory(Category::class)->create();
        //$response = $this->json('GET', route('categories.show', $category->id));
        $response = $this->json('GET', "/api/categories/$category->id");

        $response->assertOk();
        $response->assertJsonStructure([ 'id', 'name', 'description', 'category_parent_id', 'created_at', 'updated_at']);
        $response->assertJson(['name' => $category->name, 'description' => $category->description ]);
    }

    public function test_show_not_found_category()
    {
        $response = $this->json('GET',"/api/categories/5000");
        $response->assertHeader('Content-type', 'application/json');
        $response->assertNotFound();
        $response->assertJson([
            'message' => 'Not found'
        ]);
    }

    public function test_delete_category_wo_parent()
    {
        $category = factory(Category::class)->create()->toArray();
        $id = $category['id'];
        $response = $this->json('DELETE',"/api/categories/$id");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', $category);
    }


}
