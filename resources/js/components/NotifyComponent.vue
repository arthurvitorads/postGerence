<template>
  <v-snackbar v-model="visible" :color="color" timeout="3000">
    {{ message }}
  </v-snackbar>
</template>

<script>
export default {
  props: ['type', 'message'],
  data() {
    return {
      visible: true,
    }
  },
  computed: {
    color() {
      switch (this.type) {
        case 'success': return 'green'
        case 'error': return 'red'
        case 'info': return 'blue'
        default: return 'grey'
      }
    }
  }
}
</script>
