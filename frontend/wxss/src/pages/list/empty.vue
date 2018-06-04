<template>
<div class="empty">
  <div class='weui-msg'>
    <div class="weui-msg__icon-area">
        <icon type='info' size='93' />
    </div>
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title">暂无记录</h2>
        <p class="weui-msg__desc">本次出差尚未消费</p>
    </div>
  </div>
  <Button type="primary" class="weui-btn" @click="toHome">
    立即记账
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
    toHome () {
      this.$router.push(Path.home)
    }
  }
}
</script>

<style scoped>
.empty{
  padding-top: 48px; 
}
.weui-btn {
  width: 64%;
}
</style>
