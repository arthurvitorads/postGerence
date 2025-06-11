<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register</title>
  @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
  <div id="app">
    <register-component></register-component>
  </div>
</body>
</html>
