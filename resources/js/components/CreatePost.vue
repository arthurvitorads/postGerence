<template>
  <v-app>
    <v-container>
      <v-row class="mb-4" justify="space-between">
        <v-col cols="auto">
          <h1 class="text-h4 btn-create-post" data-testid="btn-create-post">Criar Post</h1>
        </v-col>
        <v-col cols="auto">
          <v-btn color="secondary" @click="goBack">Cancelar</v-btn>
        </v-col>
      </v-row>

      <v-form @submit.prevent="submitPost" ref="form">
      <v-text-field
        v-model="form.title"
        label="Título"
        :error-messages="errors.title"
        required
        outlined
        class="mb-4"
        data-testid="input-title"
      />

      <v-textarea
        v-model="form.description"
        label="Descrição"
        :error-messages="errors.description"
        rows="5"
        required
        outlined
        class="mb-4"
        data-testid="input-description"
      />

      <v-btn type="submit" color="success" data-testid="btn-submit">Salvar</v-btn>
      </v-form>
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      form: {
        title: '',
        description: ''
      },
      errors: {
        title: [],
        description: []
      }
    }
  },
  methods: {
    async submitPost() {
      try {
        const token = document.querySelector('meta[name="csrf-token"]').content
        await axios.post('/posts', this.form, {
          headers: {
            'X-CSRF-TOKEN': token
          }
        })
        window.location.href = '/home'
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors
        } else {
          console.error('Erro ao criar post:', error)
        }
      }
    },
    goBack() {
      window.location.href = '/home'
    }
  }
}
</script>
