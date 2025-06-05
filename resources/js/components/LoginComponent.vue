<template>
  <v-app>
    <v-main>
      <v-container fluid class="fill-height">
        <v-row align-itens="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="pa-6" elevation="10">
              <v-card-title class="text-h6 mb-4">Login</v-card-title>
              <v-form @submit.prevent="login" ref="form">
                <v-text-field
                  v-model="email"
                  label="Email"
                  prepend-inner-icon="mdi-email"
                  required
                ></v-text-field>

                <v-text-field
                  v-model="password"
                  label="Senha"
                  type="password"
                  prepend-inner-icon="mdi-lock"
                  required
                ></v-text-field>

                <v-btn
                  type="submit"
                  color="primary"
                  block
                  class="mt-4"
                >
                  Entrar
                </v-btn>
              </v-form>

              <v-divider class="my-4"></v-divider>

              <v-btn
                text
                color="secondary"
                block
                @click="goToRegister"
              >
                Ainda não tem conta? Cadastre-se
              </v-btn>

              <notify-component
                v-if="notification"
                :type="notification.type"
                :message="notification.message"
                class="mt-4"
              />
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
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
    },
    goToRegister() {
      window.location.href = '/register'
    }
  }
}
</script>
