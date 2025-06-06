<template>
  <v-app>
    <v-main>
      <v-container fluid class="fill-height">
        <v-row align-itens="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="pa-6" elevation="10">
              <v-card-title class="text-h6 mb-4">Registro</v-card-title>

              <v-form @submit.prevent="register">
                <v-text-field
                  label="Nome"
                  v-model="name"
                  prepend-inner-icon="mdi-account"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-text-field
                  label="Email"
                  v-model="email"
                  prepend-inner-icon="mdi-email"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-text-field
                  label="Senha"
                  v-model="password"
                  type="password"
                  prepend-inner-icon="mdi-lock"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-btn
                  type="submit"
                  color="success"
                  block
                  class="mt-4"
                  :loading="loading"
                  :disabled="loading"
                >
                  Registrar
                </v-btn>
              </v-form>

              <v-divider class="my-4"></v-divider>

              <v-btn
                text
                color = "primary"
                block
                @click="goToLogin"
                :disabled="loading"
              >
                Já tem uma conta? Faça login
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
  components: {
    NotifyComponent
  },
  data() {
    return {
      name: '',
      email: '',
      password: '',
      notification: null,
      loading: false,
    }
  },
  methods: {
    async register() {
      this.loading = true
      this.notification = null
      try {
        await axios.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        })
        this.notification = { type: 'success', message: 'Registrado com sucesso!' }
        setTimeout(() => window.location.href = '/login', 2000)
        // NÃO seta loading=false aqui, mantém botão travado até redirecionar
      } catch (err) {
        if (err.response?.status === 422) {
          const errors = err.response.data.errors
          const messages = Object.values(errors).flat().join(' | ')
          this.notification = { type: 'error', message: messages }
        } else {
          const message = err.response?.data?.message || 'Erro ao registrar'
          this.notification = { type: 'error', message }
        }
        this.loading = false // libera formulário em caso de erro
      }
    },
    goToLogin() {
      if (!this.loading) {
        window.location.href = '/login'
      }
    }
  }
}
</script>
