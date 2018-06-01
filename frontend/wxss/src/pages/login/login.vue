<template>
  <div class="container">
    <toast />

    <img src="/static/img/logo.png" alt="logo" class="login-logo"/>

    <div class="login-from">
      <div class="login-input">
        <input type="number" placeholder="帐号" v-model="username" />
      </div>
      <div class="login-input">
        <input type="password" password='true' placeholder="密码" v-model="password" />
      </div>

      <Button type="primary" class="weui-btn" :disabled="status === 'pending'" @click="login">
        {{btnText}}
      </Button>
    </div>

  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

import toast from '@/components/toast'

export default {
  components: {
    toast
  },
  data () {
    return {
      username: '',
      password: '',
    }
  },
  computed: {
    ...mapState({
      status: state => state.login.status,
    }),
    btnText () {
      if (this.status === 'pending') {
        return '登录中...'
      } else {
        return '登录'
      }
    },
  },
  created () {
    // 如果填过用户名则自动填上
    let username = wx.getStorageSync('username')
    if (username) {
      this.username = username
    }
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
      let that = this
      let username = this.username
      let password = this.password

      if (!username) {
        this.showToast({msg: '请填写资金帐号'})
      } else if (!password) {
        this.showToast({msg: '请填写密码'})
      } else {
        this.loginAsync({
          username: username,
          password: password,
          callback: (data) => {
            // 缓存用户名和token
            wx.setStorageSync('username', data.username)
            wx.setStorageSync('access_token', data.access_token)
            // 登录成功后跳转
            wx.switchTab({
              url: Path.home
            }) 
          }
        })
      } 
    }
  }
}
</script>

<style scoped>
.login-logo{
    display: block;
    width: 20vw;
    height: 20vw;
    padding: 40px 0 36px;
    margin: auto;
}

.login-from{
    width: 100%;
    padding: 15px;
    box-sizing: border-box;
}
.login-input{
    width: 100%;
    margin: 10px 0;
    box-sizing: border-box;
    background-color: #e0e0e0;
    border-radius: 5px;
    padding: 9px 12px;
}

</style>
