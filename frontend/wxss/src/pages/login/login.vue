<template>
  <div class="container">
    <toast />

    <Button type="primary" class="weui-btn" @click="login">
      登录
    </Button>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

import toast from '@/components/toast'

export default {
  components: {
    toast
  },
  data () {
    return {
    }
  },
  computed: {
    ...mapState({
      status: state => state.login.status,
    })
  },
  methods: {
    ...mapMutations({
      showToast: 'showToast',
    }),
    ...mapActions({
      loginAsync: 'loginAsync',
      getUserAsync: 'getUserAsync',
    }),
    login () {
      this.showToast({msg: '登录功能未实现'})
    }
  }
}
</script>

<style scoped>
</style>
