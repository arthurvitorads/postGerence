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

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456')
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'errado',
        ]);

        $response->assertStatus(401);
        $this->assertGuest();
    }

    public function test_user_can_request_password_reset_link()
    {
        app()->setLocale('en'); 
        
        $user = User::factory()->create();

        $response = $this->postJson('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Enviamos o link de recuperação para seu email!',
        ]);

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_password_reset_fails_with_invalid_email()
    {
        $response = $this->postJson('/forgot-password', [
            'email' => 'emailinvalido@teste.com',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Não encontramos um usuário com esse email.',
        ]);
    }

}
