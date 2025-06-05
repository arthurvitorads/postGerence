<template>
  <v-app>
    <v-container>
      <v-form @submit.prevent="register">
        <v-text-field label="Nome" v-model="name" required></v-text-field>
        <v-text-field label="Email" v-model="email" required></v-text-field>
        <v-text-field label="Senha" v-model="password" type="password" required></v-text-field>
        <v-btn type="submit" color="success">Registrar</v-btn>
      </v-form>
      <notify-component v-if="notification" :type="notification.type" :message="notification.message" />
    </v-container>
  </v-app>
</template>

<script>
import NotifyComponent from './NotifyComponent.vue'
import axios from 'axios'

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      notification: null,  // <-- declare aqui
    }
  },
  components: {
    NotifyComponent
  },
  methods: {
    async register() {
      try {
        await axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        })
        this.notification = { type: 'success', message: 'Registrado com sucesso!' }
        window.location.href = '/login'
      } catch (err) {
        if (err.response?.status === 422) {
          // Extrai as mensagens de validação
          const errors = err.response.data.errors
          const messages = Object.values(errors).flat().join(' | ')
          this.notification = { type: 'error', message: messages }
        } else {
          const message = err.response?.data?.message || 'Erro ao registrar'
          this.notification = { type: 'error', message }
        }
      }
    },
  },
}
</script>
