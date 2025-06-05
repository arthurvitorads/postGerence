<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_successfully()
    {
        $response = $this->postJson('/register', [
            'name' => 'João',
            'email' => 'joao@example.com',
            'password' => '123456',
        ]);

        // Resposta que esperamos
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'joao@example.com']);
    }

    public function test_registration_fails_with_invalid_data()
    {
        $response = $this->postJson('/register', [
            'name' => '',
            'email' => 'email-invalido',
            'password' => '123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function test_user_registration_successful()
    {
        $response = $this->postJson('/register', [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'joao@example.com',
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'errado',
        ]);

        $response->assertStatus(401); // Supondo que você retorna isso no controller
        $this->assertGuest();
    }
}
