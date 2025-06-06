<template>
  <v-app>
    <v-main>
      <v-container fluid class="fill-height">
        <v-row align-itens="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="pa-6" elevation="10">
              <v-card-title class="text-h6 mb-4">Recuperar Senha</v-card-title>

              <v-form @submit.prevent="submit">
                <v-text-field
                  v-model="email"
                  label="Email"
                  prepend-inner-icon="mdi-email"
                  type="email"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-btn
                  type="submit"
                  color="primary"
                  block
                  :disabled="loading"
                >
                  Enviar link de recuperação
                </v-btn>
              </v-form>

              <v-divider class="my-4"></v-divider>

              <v-btn
                text
                color="secondary"
                block
                @click="goBack"
                :disabled="loading"
              >
                Voltar ao login
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
      loading: false,
      notification: null,
    }
  },
  methods: {
    async submit() {
      this.loading = true
      this.notification = null

      try {
        await axios.post('/forgot-password', {
          email: this.email
        })

        this.notification = {
          type: 'success',
          message: 'Se o email existir, um link de recuperação foi enviado.'
        }
      } catch (err) {
        const message = err.response?.data?.message || 'Erro ao enviar solicitação'
        this.notification = { type: 'error', message }
      } finally {
        this.loading = false
      }
    },
    goBack() {
      if (!this.loading) {
        window.location.href = '/login'
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
