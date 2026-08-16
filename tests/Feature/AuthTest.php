<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Auth\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_returns_a_user_and_token(): void
    {
        $this->postJson('/api/register', [
            'name' => 'Bob',
            'email' => 'bob@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
            ->assertStatus(201)
            ->assertJsonPath('user.email', 'bob@test.com')
            ->assertJsonPath('user.is_admin', false)
            ->assertJsonStructure(['message', 'user' => ['id', 'name', 'email'], 'token']);
    }

    public function test_login_with_bad_credentials_returns_422(): void
    {
        User::factory()->create(['email' => 'bob@test.com']);

        $this->postJson('/api/login', [
            'email' => 'bob@test.com',
            'password' => 'wrong-password',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_logout_revokes_the_current_token(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $this->assertSame(1, PersonalAccessToken::count());

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/logout')
            ->assertStatus(200);

        $this->assertSame(0, PersonalAccessToken::count());
    }

    public function test_logout_does_not_error_without_a_personal_access_token(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/logout')
            ->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully.']);
    }
}
