<template>
  <div class="container">
    登录页
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  data () {
    return {
      motto: 'Hello World',
    }
  },
  computed: {
    ...mapState({
      test: state => state.homeApp.test,
    })
  },
  methods: {
    ...mapMutations({
      on: 'on',
      off: 'off',
    }),
  }
}
</script>

<style scoped>
</style>
