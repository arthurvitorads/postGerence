import './bootstrap'
import Vue from 'vue/dist/vue.esm.js'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import axios from 'axios'


axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://127.0.0.1:8000';
Vue.prototype.$axios = axios;

Vue.use(Vuetify)

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found in meta tag');
}

axios.defaults.withCredentials = true

import LoginComponent from './components/LoginComponent.vue'
import RegisterComponent from './components/RegisterComponent.vue'
import HomeComponent from './components/HomeComponent.vue'
import PostsView from './components/PostsView.vue'
import CreatePost from './components/CreatePost.vue'
import EditPost from './components/EditPost.vue'  
import ForgotPasswordComponent from './components/ForgotPasswordComponent.vue'
import ResetPassword from './components/ResetPassword.vue'

Vue.component('login-component', LoginComponent)
Vue.component('register-component', RegisterComponent)
Vue.component('home-component', HomeComponent)
Vue.component('posts-view', PostsView)
Vue.component('create-post', CreatePost)
Vue.component('edit-post', EditPost)
Vue.component('forgot-password-component', ForgotPasswordComponent)
Vue.component('reset-password', ResetPassword)

// Instância Vue
new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  methods: {
    logout() {
      fetch('/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'include'
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