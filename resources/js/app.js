import './bootstrap';

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

import LoginComponent from './components/LoginComponent.vue'
import RegisterComponent from './components/RegisterComponent.vue'
import HomeComponent from './components/HomeComponent.vue';
import PostsView from './components/PostsView.vue';

new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  components: {
    LoginComponent,
    RegisterComponent,
    HomeComponent,
    PostsView
  },
  methods: {
    logout() {
      fetch('/logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
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
