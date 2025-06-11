<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Criar Post</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
  <div id="app">
    <create-post></create-post>
  </div>
</body>
</html>
