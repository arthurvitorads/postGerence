<!DOCTYPE html>
<html lang="pt-BR">

<head>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
</head>

<body>
    <div id="app">
        <login-component></login-component>
    </div>
</body>

</html>