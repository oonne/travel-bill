<template>
<div class="no-login">
  <div class='weui-msg'>
    <div class="weui-msg__icon-area">
        <icon type='info' size='93' />
    </div>
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title">未登录</h2>
        <p class="weui-msg__desc">请先登录</p>
    </div>
  </div>
  <Button type="primary" class="weui-btn" @click="toLogin">
    立即登录
  </Button>
</div>
</template>

<script>
import Path from '@/config/path'

export default {
  data () {
    return {
    }
  },
  methods: {
    toLogin () {
      this.$router.push(Path.login)
    }
  }
}
</script>

<style scoped>
.no-login{
  padding-top: 48px; 
}
.weui-btn {
  width: 64%;
}
</style>
