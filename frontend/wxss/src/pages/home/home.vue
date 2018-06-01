<template>
  <div class="container">
    <noLogin v-if="!isLogin"/>
    <div v-else>
      首页内容
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
  data () {
    return {
    }
  },
  computed: {
    ...mapState({
      isLogin: state => state.login.isLogin,
    })
  },
  methods: {
    ...mapMutations({
    })
  }
}
</script>

<style scoped>
</style>
