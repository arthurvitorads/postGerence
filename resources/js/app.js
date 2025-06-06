import './bootstrap'
import Vue from 'vue/dist/vue.esm.js'  // já importa o Vue com o compilador
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import axios from 'axios'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://127.0.0.1:8000';
Vue.prototype.$axios = axios;

Vue.use(Vuetify)

// Configura o Axios para usar o CSRF Token
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found in meta tag');
}

// Permitir envio de cookies de sessão (auth via Laravel)
axios.defaults.withCredentials = true

// Importa componentes
import LoginComponent from './components/LoginComponent.vue'
import RegisterComponent from './components/RegisterComponent.vue'
import HomeComponent from './components/HomeComponent.vue'
import PostsView from './components/PostsView.vue'
import CreatePost from './components/CreatePost.vue'
import EditPost from './components/EditPost.vue'  
import ForgotPasswordComponent from './components/ForgotPasswordComponent.vue'
import ResetPassword from './components/ResetPassword.vue'

new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  components: {
    LoginComponent,
    RegisterComponent,
    HomeComponent,
    PostsView,
    CreatePost,
    EditPost,
    ForgotPasswordComponent,
    ResetPassword
  },
  methods: {
    logout() {
      fetch('/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'include' // Inclui cookies na requisição fetch também
      })
        .then(() => {
          window.location.href = '/login'
        })
        .catch(e => {
          console.error('Erro ao fazer logout', e)
        })
    }
  }
})
