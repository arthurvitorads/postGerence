
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <title>Home</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
  <div id="app">
    <home-component></home-component>
  </div>
</body>
</html>
