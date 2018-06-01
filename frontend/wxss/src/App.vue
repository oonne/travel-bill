<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

export default {
  created () {
    let that = this
    // 读取token，如果没有token则直接跳转到退出登录，有token则请求基本数据
    wx.getStorage({
      key: 'access_token',
      success: (res) => {
        that.login()
        that.getUserAsync()
      },
      fail: (res) => {
        that.logout()
        that.$router.push(Path.login)
      }
    })
  },
  computed: {
    ...mapState({
      isLogin: state => state.user.isLogin
    })
  },
  methods: {
    ...mapMutations({
      login: 'login',
      logout: 'logout',
    }),
    ...mapActions({
      loginAsync: 'loginAsync',
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
</style>
