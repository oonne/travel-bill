<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

export default {
  created () {
    let that = this
    // 读取token，如果没有token则直接跳转到退出登录，有token则请求基本数据
    wx.getStorage({
      key: 'token',
      success: (res) => {
        that.login({token: res.data})
      },
      fail: (res) => {
        that.logout()
        that.$router.push(Path.login)
      }
    })
  },
  computed: {
    ...mapState({
      isLogin: state => state.login.isLogin,
    })
  },
  methods: {
    ...mapMutations({
      login: 'login',
      logout: 'logout',
    }),
    ...mapActions({
      loginAsync: 'loginAsync',
    }),

  }
}
</script>

<style>
@import "../static/weui.wxss";

.container {
  height: 100%;
}
</style>
