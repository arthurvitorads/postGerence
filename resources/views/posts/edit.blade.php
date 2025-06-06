<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Post</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
  <div id="app">
    <edit-post
      :post-id="{{ $post->id }}"
      :initial-post='@json($post)'
    ></edit-post>
  </div>
</body>
</html>
