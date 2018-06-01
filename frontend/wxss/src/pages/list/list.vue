<template>
  <div class="container">
    <noLogin v-if="!isLogin"/>
    <div v-else>
      列表页面
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

import noLogin from '@/components/noLogin'

export default {
  components: {
    noLogin
  },
  computed: {
    ...mapState({
      isLogin: state => state.login.isLogin,
    })
  },
  mounted () {
   // TODO 获取第一页数据
  }
}
</script>

<style scoped>
</style>
