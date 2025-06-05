<template>
  <v-app>
    <v-container>
      <v-form @submit.prevent="login">
        <v-text-field v-model="email" label="Email"></v-text-field>
        <v-text-field v-model="password" label="Senha" type="password"></v-text-field>
        <v-btn type="submit" color="primary">Entrar</v-btn>
      </v-form>
      <notify-component v-if="notification" :type="notification.type" :message="notification.message" />
    </v-container>
  </v-app>
</template>

<script>
import NotifyComponent from './NotifyComponent.vue'
import axios from 'axios'

export default {
  components: { NotifyComponent },
  data() {
    return {
      email: '',
      password: '',
      notification: null,
    }
  },
  methods: {
    async login() {
      try {
        await axios.post('/login', {
          email: this.email,
          password: this.password,
        })
        this.notification = { type: 'success', message: 'Login realizado com sucesso!' }
        setTimeout(() => window.location.href = '/home', 1000)
      } catch (err) {
        const message = err.response?.data?.message || 'Erro ao logar'
        this.notification = { type: 'error', message }
      }
    }
  }
}
</script>
