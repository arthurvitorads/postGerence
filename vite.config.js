import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue2'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  resolve: {
    alias: {
      'vue': 'vue/dist/vue.esm.js',  // <-- aqui o alias
    },
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
  server: {
    host: 'localhost',
    port: 5173,
    hmr: {
      host: 'localhost',
    },
  },
})
