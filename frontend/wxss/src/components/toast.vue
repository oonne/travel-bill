<template>
<div class='toast' v-show="show">
  {{msg}}
</div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
  watch: {
    show (show) {
      // 一段时间后自动关闭
      let that = this
      if (show) {
        setTimeout(function () {
          that.hideToast()
        }, 1500)
      }
    }
  },
  computed: {
    ...mapState({
      show: state => state.toast.show,
      msg: state => state.toast.msg
    })
  },
  methods: {
    ...mapMutations({
      hideToast: 'hideToast'
    })
  }
}
</script>

<style scoped>
  .toast{
    position: fixed;
    top: 54vh;
    left: 50vw;
    transform: translateX(-50%);
    max-width: 70vw;
    padding: 6px 8px;
    border-radius: 2px;
    font-size: 14px;
    text-align: center;
    background-color: #000;
    color: #fff;
    z-index: 10000;
    opacity: 0.88;
  }
</style>
