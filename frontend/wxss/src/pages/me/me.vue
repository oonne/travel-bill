<template>
  <div class="container">

    <div class="me-header" :class="{ 'me-header-wxss': is_wxss }">
      <img v-if="hasUserInfo" class="avatar" :src="userInfo.avatarUrl" alt="avatar" />
      <button v-else open-type="getUserInfo" @getuserinfo="getUserInfo" class="avatar"><img class="avatar-img" :src="avatar" alt="avatar" /></button>
      
      <div class="me-name">{{userName}}</div>
      <div class="me-trip">{{tripName}}</div>

      <div class="waveWrapperInner bgTop">
        <img class="wave waveTop1" :src="waveTop" />
        <img class="wave waveTop2" :src="waveTop" />
      </div>
      <div class="waveWrapperInner bgMiddle">
        <img class="wave waveMiddle1" :src="waveTop" />
        <img class="wave waveMiddle2" :src="waveTop" />
        <img class="wave waveMiddle3" :src="waveTop" />
      </div>
      <div class="waveWrapperInner bgBottom">
        <img class="wave waveBottom1" :src="waveTop" />
        <img class="wave waveBottom2" :src="waveTop" />
        <img class="wave waveBottom3" :src="waveTop" />
      </div>
    </div>


    <div class="btn-area">
      <Button v-if="isLogin" type="default" class="weui-btn" @click="logout">
        退出登录
      </Button>
      <Button v-else type="default" class="weui-btn" @click="toLogin">
        立即登录
      </Button>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'
import avatar from './avatar.jpg'
import waveTop from './wave-top.png'

export default {
  data () {
    return {
      hasUserInfo: false,
      userInfo: {},
    }
  },
  computed: {
    ...mapState({
      isLogin: state => state.user.isLogin,
      user: state => state.user.user,
    }),
    avatar () {
      return avatar
    },
    waveTop () {
      return waveTop
    },
    userName () {
      if (this.isLogin) {
        return this.user.handler_name
      } else {
        return '未登录'
      }
    },
    tripName () {
      if (this.user.trip_name) {
        return this.user.trip_name
      } else {
        return ''
      }
    }
  },
  created () {
    let that = this
    wx.getUserInfo({
      success: res => {
        that.hasUserInfo = true
        that.userInfo = res.userInfo
      }
    }) 
  },
  methods: {
    ...mapMutations({
      logout: 'logout'
    }),
    ...mapActions({
    }),
    toLogin (path) {
      this.$router.push(Path.login)
    },
    showLogout () {
      let that = this
      wx.showModal({
        title: '确认退出登录？',
        confirmText: '退出',
        confirmColor: '#17a4fe',
        success: (res) => {
          if (res.confirm) {
            that.logout()
          }
        }
      })
    },
    getUserInfo (e) {
      let userInfo = e.mp.detail.userInfo
      this.hasUserInfo = true
      this.userInfo = userInfo
    }
  }
}
</script>

<style scoped>
.me-header{
    position: relative;
    box-sizing: border-box;
    height: 200px;
    width: 100%;
    padding: 10px 20px;
    background-color: #1fa8ff;
    background-image: linear-gradient(to top, #1fa8ff 20%, #0981dd 80%);
    z-index: 1;
}
.bgTop {
    z-index: 3;
    opacity: 0.3;
}
.bgMiddle {
    z-index: 2;
    opacity: 0.6;
}
.bgBottom {
    z-index: 1;
}
.waveWrapperInner {
    position: absolute;
    width: 100%;
    height: 60px;
    overflow: hidden;
    bottom: -1px;
    left: 0;
    right: 0;
}
.wave {
    position: absolute;
    bottom: 0;
    width: 200%;
    height: 100%;
    transform-origin: center bottom;
}
.waveTop1 {
    animation: move_wave 5s linear infinite;
    height: 26px;
    width: 100vw;
    left: 0;
}
.waveTop2 {
    animation: move_wave 5s linear infinite;
    height: 26px;
    width: 100vw;
    left: 100vw;
}
.waveMiddle1 {
    animation: move_wave 10s linear infinite;
    height: 30px;
    width: 100vw;
    left: -30vw;
}
.waveMiddle2 {
    animation: move_wave 10s linear infinite;
    height: 30px;
    width: 100vw;
    left: 70vw;
}
.waveMiddle3 {
    animation: move_wave 10s linear infinite;
    height: 30px;
    width: 100vw;
    left: 170vw;
}
.waveBottom1 {
    animation: move_wave 15s linear infinite;
    height: 32px;
    width: 100vw;
    left: -60vw;
}
.waveBottom2 {
    animation: move_wave 15s linear infinite;
    height: 32px;
    width: 100vw;
    left: 40vw;
}
.waveBottom3 {
    animation: move_wave 15s linear infinite;
    height: 32px;
    width: 100vw;
    left: 140vw;
}

@keyframes move_wave {
    0% {
        transform: translateX(-100%) translateZ(0) scaleY(1)
    }
    50% {
        transform: translateX(-50%) translateZ(0) scaleY(0.55)
    }
    100% {
        transform: translateX(0) translateZ(0) scaleY(1)
    }
}

.avatar{
    display: block;
    width: 65px;
    height: 65px;
    border-radius: 100%;
    border: 2px solid #fff;
    margin: auto;
    padding: 0;
}
.avatar-img{
    display: block;
    width: 100%;
    height: 100%;
}
.me-name{
    width: 100%;
    color: #fff;
    text-align: center;
    margin: 8px 0 0;
    font-size: 18px;
}
.me-trip{
    width: 100%;
    color: #fff;
    text-align: center;
    margin: 8px 0 0;
    font-size: 14px;
}

.btn-area{
  width: 100%;
  box-sizing: border-box;
  padding: 20px 10px;
}
</style>
