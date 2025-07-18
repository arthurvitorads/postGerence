<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home - Posts</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div id="app">
        <posts-view
            :initial-posts='@json($posts)'
            :user='@json(Auth::user())'
        ></posts-view>
    </div>
</body>
</html>
