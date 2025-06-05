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
        <v-app>
            <v-container>
                <h1>Bem-vindo à Home!</h1>
                <v-btn color="error" @click="logout">Logout</v-btn>
            </v-container>
        </v-app>
    </div>

    <script>
        new Vue({
            el: '#app',
            methods: {
                logout() {
                    fetch('/logout', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(() => {
                            window.location.href = '/login'
                        })
                        .catch(e => {
                            console.error('Logout falhou', e)
                        })
                }
            }
        });
    </script>
</body>
</html>