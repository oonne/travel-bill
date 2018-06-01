<template>
  <div class="container">
    个人中心
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

export default {
  computed: {
    ...mapState({
      isLogin: state => state.user.isLogin,
      user: state => state.user.user,
      category: state => state.base.category,
      trip: state => state.base.trip,
      handler: state => state.base.handler,
    })
  },
  onShow () {
  	console.log(this.user)
  	console.log(this.category)
  	console.log(this.trip)
  	console.log(this.handler)
  }
}
</script>

<style scoped>
</style>
