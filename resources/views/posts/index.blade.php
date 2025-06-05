@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Posts</h1>

    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;" class="mb-3"> 
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Criar Post</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($posts as $post)
    <div class="card mb-3">
        <div class="card-header">
            <strong>{{ $post->title }}</strong> por {{ $post->user->name }}
        </div>
        <div class="card-body">
            <p>{{ $post->description }}</p>

            @can('update', $post)
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Editar</a>
            @endcan

            @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirma exclusão?')">Excluir</button>
            </form>
            @endcan
        </div>
    </div>
    @endforeach
</div>
@endsection