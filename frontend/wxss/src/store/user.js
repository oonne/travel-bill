import Request from '../utils/request'
import Util from '../utils/util'
import Url from '../config/url'

export default {
  state: {
    isLogin: false,
    status: '',
    user: {}
  },
  mutations: {
    login (state, data) {
      state.isLogin = true
      state.status = ''
    },
    logout (state, data) {
      state.isLogin = false
      state.user = {}
      wx.removeStorageSync('access_token')
    },
    loginPadding (state, data) {
      state.status = 'pending'
    },
    loginSuccess (state, data) {
      state.isLogin = true
      state.status = 'success'
    },
    loginError (state, data) {
      state.status = 'error'
    },
    setUser (state, data) {
      state.user = data
    },
    setUserTrip (state, data) {
      state.user.trip_id = data.id
      state.user.trip_name = data.trip_name
    },
  },
  actions: {
    async loginAsync ({ commit }, options) {
      commit('loginPadding')
      
      let reqParams = {
        username: options.username,
        password: options.password,
      }
      Request.post('/user/login', reqParams, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('loginSuccess')
          commit('setUser', data.Data)
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
      Request.get('/user/get-user-info', options, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('setUser', data.Data.user)
          commit('setCategory', data.Data.category)
          commit('setTrip', data.Data.trip)
          commit('setHandler', data.Data.handler)
        }
      }).catch((e) => {
        console.warn('获取用户资料失败')
      })
    },
    async setTripAsync ({ commit, rootState }, options) {
      let tripList = rootState.base.trip
      let trip  = tripList.find(item => item.id == options.handler_trip)

      Request.post('/user/set-trip', options, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('showToast', {msg: '切换成功'})
          commit('setUserTrip', trip)
        } else {
          commit('showToast', {msg: '切换失败'})
        }
      }).catch((e) => {
        console.warn('切换项目失败')
      })
    },
  }
}
