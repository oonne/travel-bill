import Vue from 'vue'
import MpvueRouterPatch from 'mpvue-router-patch'
import store from '@/store'
import App from '@/App'

// Vue.config.productionTip = false
// App.mpType = 'app'

// const app = new Vue(App)
// app.$mount()

Vue.config.productionTip = false
Vue.use(MpvueRouterPatch)

const app = new Vue({
  store,
  ...App
})
app.$mount()

export default {
  config: {
    pages: [],
    window: {
      backgroundTextStyle: 'light',
      backgroundColor: '#f8f8f8',
      backgroundColorTop: '#f8f8f8',
      navigationBarBackgroundColor: '#0981dd',
      navigationBarTitleText: '小程序测试',
      navigationBarTextStyle: 'white'
    },
    tabBar: {
      color: '#999',
      selectedColor: '#0a9ffd',
      backgroundColor: '#fff',
      borderStyle: 'black',
      list: [{
        pagePath: 'pages/home/home',
        text: '记账',
        iconPath: 'static/nav/icon-home.png',
        selectedIconPath: 'static/nav/icon-home-active.png'
      }, {
        pagePath: 'pages/list/list',
        text: '账单',
        iconPath: 'static/nav/icon-list.png',
        selectedIconPath: 'static/nav/icon-list-active.png'
      }, {
        pagePath: 'pages/me/me',
        text: '我',
        iconPath: 'static/nav/icon-me.png',
        selectedIconPath: 'static/nav/icon-me-active.png'
      }]
    }
  }
}
