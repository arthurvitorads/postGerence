<!DOCTYPE html>
<html lang="pt-BR">

<head>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div id="app">
        <reset-password :token="'{{ $token }}'" :email="'{{ request()->email }}'"></reset-password>
    </div>
</body>

</html>