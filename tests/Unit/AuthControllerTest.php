<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_user_and_returns_token(): void
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type']);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_login_returns_token_for_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type']);
    }

    public function test_login_fails_for_invalid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid login details']);
    }

    public function test_changePassword_updates_password_for_valid_current_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $response = $this->postJson('/api/changePassword', [
            'current_password' => 'oldpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contraseña actualizada exitosamente.']);
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_changePassword_fails_for_invalid_current_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $this->actingAs($user);

        $response = $this->postJson('/api/changePassword', [
            'current_password' => 'wrongpassword',
            'new_password' => 'newpassword',
        ]);

        $response->assertStatus(404);
    }

    public function test_logout_deletes_user_tokens(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
        $this->assertCount(0, $user->fresh()->tokens);
    }
}
