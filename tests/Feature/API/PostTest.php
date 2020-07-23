<?php

namespace Tests\Feature\API;

use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_a_new_post()
    {
        $this->withoutExceptionHandling();
        /*$user = factory(User::class)->create();
        Passport::actingAs($user);*/
        $post = factory(Post::class)->create()->toArray();

        $response = $this->json('POST', route('posts.store'), $post);

        unset($post['created_at']);
        unset($post['updated_at']);

        $response->assertStatus(201);
        $response->assertHeader('Content-type', 'application/json');
        $response->assertJsonStructure(['title', 'content', 'slug', 'owner_id', 'category_id']);

        $this->assertDatabaseHas('posts', $post);
    }
}
