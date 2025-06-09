<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->post('/posts', [
            'title' => 'Meu post',
            'description' => 'Conteúdo do post'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Meu post',
            'user_id' => $user->id
        ]);
    }

    public function test_guest_cannot_create_post()
    {
        $response = $this->post('/posts', [
            'title' => 'Post',
            'description' => 'Desc'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_can_edit_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->put("/posts/{$post->id}", [
            'title' => 'Atualizado',
            'description' => 'Texto novo'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', ['title' => 'Atualizado']);
    }

    public function test_user_cannot_edit_others_post()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $other->id]);

        $this->actingAs($user);
        $response = $this->put("/posts/{$post->id}", [
            'title' => 'Hacker!',
            'description' => 'Tentando invadir'
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->delete("/posts/{$post->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_user_cannot_delete_others_post()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $other->id]);

        $this->actingAs($user);
        $response = $this->delete("/posts/{$post->id}");

        $response->assertStatus(403);
    }

    public function test_guest_cannot_see_post_list()
    {
        Post::factory()->count(3)->create();

        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }
}
