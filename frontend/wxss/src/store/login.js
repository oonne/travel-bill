import request from '../utils/request'
import Url from '../config/url'

export default {
  state: {
    'isLogin': false,
    'token': '',
    'status': '',
  },
  mutations: {
    login (state, data) {
      state.isLogin = true
      state.status = ''
      state.token = data.token
      wx.setStorageSync('token')
    },
    logout (state, data) {
      state.isLogin = false
      state.token = ''
      wx.removeStorageSync('token')
    },
    loginPadding (state, data) {
      state.status = 'pending'
    },
    loginSuccess (state, data) {
      state.status = 'success'
    },
    loginError (state, data) {
      state.status = 'error'
    }
  },
  actions: {
    async loginAsync ({ commit }, options) {

    }
  }
}
