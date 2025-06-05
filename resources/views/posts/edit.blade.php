@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Post</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $post->title) }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="description">Descrição</label>
            <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $post->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection