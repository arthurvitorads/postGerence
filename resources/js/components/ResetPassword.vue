<template>
  <v-app>
    <v-main>
      <v-container fluid class="fill-height">
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="pa-6" elevation="10">
              <v-card-title class="text-h6 mb-4 text-center">
                Redefinir Senha
              </v-card-title>

              <v-form ref="form" @submit.prevent="submit" lazy-validation>
                <v-text-field
                  v-model="form.email"
                  label="E-mail"
                  prepend-inner-icon="mdi-email"
                  :rules="[rules.required, rules.email]"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-text-field
                  v-model="form.password"
                  label="Nova Senha"
                  prepend-inner-icon="mdi-lock"
                  type="password"
                  :rules="[rules.required, rules.min]"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-text-field
                  v-model="form.password_confirmation"
                  label="Confirmar Senha"
                  prepend-inner-icon="mdi-lock-check"
                  type="password"
                  :rules="[rules.required, rules.match]"
                  required
                  :disabled="loading"
                ></v-text-field>

                <v-btn
                  color="primary"
                  type="submit"
                  block
                  class="mt-4"
                  :loading="loading"
                  :disabled="loading"
                >
                  Redefinir Senha
                </v-btn>
              </v-form>

              <v-btn
                text
                block
                color="primary"
                class="mt-6"
                :disabled="loading"
                @click="goToLogin"
              >
                Voltar para Login
              </v-btn>

              <notify-component
                v-if="notification.message"
                :type="notification.type"
                :message="notification.message"
                @input="notification.message = ''"
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

export default {
  components: { NotifyComponent },
  props: {
    token: { type: String, required: true },
    email: { type: String, default: '' },
  },
  data() {
    return {
      form: {
        email: this.email,
        password: '',
        password_confirmation: '',
      },
      loading: false,
      notification: {
        type: '',
        message: '',
      },
    }
  },
  computed: {
    rules() {
      return {
        required: v => !!v || 'Campo obrigatório',
        email: v => /.+@.+\..+/.test(v) || 'E-mail deve ser válido',
        min: v => (v && v.length >= 6) || 'Senha deve ter ao menos 6 caracteres',
        match: v => v === this.form.password || 'Confirmação de senha deve bater',
      }
    }
  },
  methods: {
        async submit() {
        this.notification = { type: '', message: '' }

        if (!this.$refs.form.validate()) return

        this.loading = true
        try {
            const payload = { ...this.form, token: this.token }
            const response = await this.$axios.post('/reset-password', payload)
            this.notification = {
            type: 'success',
            message: response.data.message || 'Senha redefinida com sucesso!',
            }
            setTimeout(() => {
            this.goToLogin()
            }, 2000)
        } catch (err) {
            if (err.response?.data?.errors) {
            const messages = Object.values(err.response.data.errors).flat().join(' ')
            this.notification = { type: 'error', message: messages }
            } else {
            this.notification = {
                type: 'error',
                message: err.response?.data?.message || 'Erro ao redefinir senha.',
            }
            }
            this.loading = false
        }
        },
    goToLogin() {
      window.location.href = '/login'
    },
  },
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
