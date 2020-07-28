<?php

namespace Tests\Feature\API;

use App\Models\Category;
use App\Models\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_create_post_with_owner_and_category()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $category = factory(Category::class)->create();

        $post =  [
            'title' => $this->faker->name,
            'content' => $this->faker->text(250),
            'slug' => $this->faker->slug,
            'owner_id' =>  $user->id,
            'category_id' =>  $category->id
        ];
        $response = $this->json('POST', route('posts.store'), $post);

        unset($post['created_at']);
        unset($post['updated_at']);

        $response->assertStatus(201);
        $response->assertHeader('Content-type', 'application/json');
        $response->assertJsonStructure(['title', 'content', 'slug', 'owner_id', 'category_id']);
        $response->assertJson([
            'title' => $post['title'],
            'content' => $post['content'],
            'slug' => $post['slug'],
            'owner_id' => $user->id ,
            'category_id' => $category->id
        ]);

        $this->assertDatabaseHas('posts', $post);
    }

    public function test_user_only_can_delete_own_post()
    {
        $this->withoutExceptionHandling();
        $owner = factory(User::class)->create();

        Passport::actingAs($owner);
        $post = factory(Post::class)->create();

        $response = $this->json('DELETE', route('posts.destroy', $post->id));

        $response->assertStatus(403);
        $response->assertHeader('Content-type', 'application/json');

        $response->assertJsonStructure(['message']);
        $response->assertJson([
            'message' => "You can't delete this post because you aren't owner this"
        ]);
        $this->assertDatabaseMissing('posts', $post->toArray());

    }

    public function test_user_can_delete_own_post()
    {
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create();
        $user = User::find($post->owner_id);
        Passport::actingAs($user);

        $response = $this->json('DELETE', route('posts.destroy', $post->id));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('posts', $post->toArray());
    }


}
