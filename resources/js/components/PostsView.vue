<template>
  <v-app>
    <v-container>
      <v-row justify="space-between" text-align="center" class="mb-5">
        <v-col cols="auto">
          <h1 class="text-h4">Posts</h1>
        </v-col>
        <v-col cols="auto">
          <v-btn class="mr-6" color="primary" @click="goToCreate">Criar Post</v-btn>
          <v-btn color="error" @click="logout">Logout</v-btn>
        </v-col>
      </v-row>
      <v-alert
        v-model="showSuccess"
        type="success"
        dismissible
        class="mb-2"
        >
        {{ successMessage }}
        </v-alert>
        <v-card
        v-for="post in posts"
        :key="post.id"
        class="mb-4"
        elevation="2"
        >
        <v-card-title>
          <div>
            <strong>{{ post.title }}</strong> por {{ post.user.name }}
          </div>
        </v-card-title>

        <v-card-text>
          <p>{{ post.description }}</p>
        </v-card-text>

        <v-card-actions>
          <v-btn
            v-if="canEdit(post)"
            color="warning"
            small
            @click="goToEdit(post.id)"
          >
            Editar
          </v-btn>
            <v-btn
            v-if="canDelete(post)"
            color="error"
            small
            @click="() => deletePost(post.id)"
            >
            Excluir
            </v-btn>
        </v-card-actions>
      </v-card>
    </v-container>
  </v-app>
</template>

<script>
import axios from 'axios'

export default {
  props: ['initialPosts', 'user'],
    data() {
    return {
        posts: this.initialPosts,
        successMessage: '',
        showSuccess: false
    }
    },
  methods: {
    goToCreate() {
      window.location.href = '/posts/create'
    },
    goToEdit(id) {
      window.location.href = `/posts/${id}/edit`
    },
    canEdit(post) {
      return post.user_id === this.user.id
    },
    canDelete(post) {
      return post.user_id === this.user.id
    },
    async deletePost(id) {
    console.log('Tentando deletar post com ID:', id)

    if (!id) {
        console.error('ID inválido fornecido ao deletar')
        return
    }

    if (confirm('Confirma exclusão?')) {
        try {
    await axios.post(`/posts/${id}`, {
    _method: 'DELETE'
    }, {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
    })
        this.posts = this.posts.filter(post => Number(post.id) !== Number(id))
        this.successMessage = 'Post excluído com sucesso!'
        
        this.showSuccess = true
        setTimeout(() => {
        this.showSuccess = false
        }, 2000)

        } catch (error) {
        console.error('Erro ao excluir post:', error)
        }
    }
    },
    async logout() {
      try {
        await axios.post('/logout', {}, {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
        })
        window.location.href = '/login'
      } catch (e) {
        console.error('Erro ao fazer logout', e)
      }
    }
  }
}
</script>
