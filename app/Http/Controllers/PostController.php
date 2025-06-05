<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    // Exibe todos os posts (home)
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Form para criar post
    public function create()
    {
        return view('posts.create');
    }

    // Salvar post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Auth::user()->posts()->create($request->only('title', 'description'));

        return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
    }

    // Form para editar post
    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    // Atualizar post
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update($request->only('title', 'description'));

        return redirect()->route('posts.index')->with('success', 'Post atualizado com sucesso!');
    }

    // Deletar post
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post excluído com sucesso!');
    }
}
