<script>
export default {
  created () {
    // 读取token，如果没有token则退出。
    wx.getStorage({
      key: 'token',
      success: (res) => {
        console.log(res.data)
      },
      fail: (res) => {
        console.log('没有')
      }
    })
  }
}
</script>

<style>
.container {
  height: 100%;
}
</style>
