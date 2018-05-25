<template>
  <div class="container">
    <button @click="toLogin">登录</button>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

export default {
  data () {
    return {
    }
  },
  computed: {
    ...mapState({
      status: state => state.homeApp.status,
    })
  },
  methods: {
    ...mapMutations({
    }),
    toLogin () {
      this.$router.push(Path.login)
    }
  }
}
</script>

<style scoped>
</style>
