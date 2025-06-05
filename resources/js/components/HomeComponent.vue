<template>
  <v-app>
    <v-main>
      <v-container class="d-flex justify-center align-center" style="min-height: 100vh;">
        <v-card class="pa-6" max-width="500" elevation="8">
          <v-card-title class="text-h5 text-center">Bem-vindo à Home!</v-card-title>
          <v-card-text class="text-center">
            <p>Você está logado com sucesso.</p>
          </v-card-text>
          <v-card-actions class="justify-center">
            <v-btn color="error" @click="logout">Logout</v-btn>
          </v-card-actions>
        </v-card>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  methods: {
    logout() {
      fetch('/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
}
</script>
