<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  created () {
    // 读取token，有token则请求基本数据
    let that = this
    wx.getStorage({
      key: 'access_token',
      success: (res) => {
        that.login()
        that.getUserAsync()
      },
      fail: (res) => {
        that.logout()
      }
    })  
  },
  methods: {
    ...mapMutations({
      login: 'login',
      logout: 'logout',
    }),
    ...mapActions({
      getUserAsync: 'getUserAsync',
    }),
  }
}
</script>

<style>
@import "../static/wxss/weui.wxss";

.container {
  min-height: 100vh;
  background-color: #f8f8f8;
}

/*weui*/
.weui-btn[type=primary] {
  background-color: #0a9ffd;
}
.button-hover[type=primary] {
  background-color: #1b9aeb;
}
.weui-btn[disabled][type=primary]{
  background-color: #57b6f2;
}

.weui-loadmore__tips_in-line{
  background-color: #f8f8f8;
}
</style>
