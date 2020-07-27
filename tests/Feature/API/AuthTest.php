<?php

namespace Tests\Feature\API;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function user_can_login()
    {
        $this->withoutExceptionHandling();
        $user = factory( User::class)->create();

        $response = $this->json('POST', '/api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token', 'token_type', 'user_id', 'rol'
        ]);
    }

    public function test_user_cannot_login_credentials_invalid()
    {
        $response = $this->json('POST', route('login'), [
            'email' => 'email@email.com',
            'password' => 'password1'
        ]);

        $response->assertStatus(401);
    }
}
