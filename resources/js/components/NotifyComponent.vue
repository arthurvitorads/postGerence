<!-- <template>
  <v-snackbar v-model="visible" :color="color" timeout="20000">
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
</script> -->
<template>
  <v-snackbar v-model="visible" :color="color" timeout="10000" data-testid="snackbar">
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
  watch: {
    message(newMsg) {
      if (newMsg) {
        this.visible = true
      } else {
        this.visible = false
      }
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
