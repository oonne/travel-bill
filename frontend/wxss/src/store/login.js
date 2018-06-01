import Request from '../utils/request'
import Util from '../utils/util'
import Url from '../config/url'

export default {
  state: {
    isLogin: false,
    status: '',
    access_token: '',
    user: {}
  },
  mutations: {
    login (state, data) {
      state.isLogin = true
      state.status = ''
      state.access_token = data.access_token
    },
    logout (state, data) {
      state.isLogin = false
      state.access_token = ''
      wx.removeStorageSync('access_token')
    },
    loginPadding (state, data) {
      state.status = 'pending'
    },
    loginSuccess (state, data) {
      state.status = 'success'
    },
    loginError (state, data) {
      state.status = 'error'
    },
    setUser (state, data) {
      state.user = data
    },
  },
  actions: {
    async loginAsync ({ commit }, options) {
      let reqParams = {
        username: options.username,
        password: options.password,
      }
      Request.post('/user/login', reqParams, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('loginSuccess')
          commit('login', data.Data)
          options.callback(data.Data)
        } else {
          commit('showToast', {msg: Util.getFirstAttr(data.Data.errors)})
          commit('loginError')
        }
      }).catch((e) => {
        commit('showToast', {msg: '登录失败'})
        commit('loginError')
      })
    },
    async getUserAsync ({ commit }, options) {

    },
  }
}
