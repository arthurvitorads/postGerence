<template>
  <v-app>
    <v-main>
      <v-container fluid class="fill-height">
        <v-row align-items="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="pa-6" elevation="10">
              <v-card-title class="text-h6 mb-4">Login</v-card-title>
              <v-form @submit.prevent="login" ref="form">
              <v-text-field
                v-model="email"
                label="Email"
                prepend-inner-icon="mdi-email"
                required
                :disabled="loading"
                data-testid="input-email"
              />

              <v-text-field
                v-model="password"
                label="Senha"
                type="password"
                prepend-inner-icon="mdi-lock"
                required
                :disabled="loading"
                data-testid="input-password"
              />

              <v-btn
                type="submit"
                color="primary"
                block
                class="mt-4"
                :disabled="loading"
                data-testid="btn-submit"
              >
                Entrar
              </v-btn>
                <v-btn
                  text
                  color = "primary"
                  block
                    class   = "mt-2"
                    @click  = "goToForgot"
                  :disabled = "loading"
                >
                  Esqueceu a senha?
                </v-btn>
              </v-form>

              <v-divider class="my-4"></v-divider>

              <v-btn
                text
                color="secondary"
                block
                @click="goToRegister"
                :disabled="loading"
              >
                Ainda não tem conta? Cadastre-se
              </v-btn>

              <notify-component
                v-if="notification"
                :type="notification.type"
                :message="notification.message"
                class="notification-snackbar"
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
      loading: false,
    }
  },
  methods: {
    async login() {
      this.loading = true
      this.notification = null
      try {
        await axios.post('/login', {
          email: this.email,
          password: this.password,
        })

        this.notification = { type: 'success', message: 'Login realizado com sucesso!' }

        setTimeout(() => {
          window.location.href = '/posts'
        }, 1000)

      } catch (err) {
        const message = err.response?.data?.message || 'Erro ao logar'
        this.notification = { type: 'error', message }
        this.loading = false 
      }
    },
    goToRegister() {
      if (!this.loading) {
        window.location.href = '/register'
      }
    },

    goToForgot() {
      if (!this.loading) {
        window.location.href = '/forgot-password'
      }
    }
  }
}
</script>

<style scoped>
.notification-snackbar {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 9999;
}
</style>
