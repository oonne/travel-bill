import Request from '../utils/request'
import Util from '../utils/util'
import Url from '../config/url'

export default {
  state: {
  	'status': ''
  },
  mutations: {
    addPadding (state, data) {
      state.status = 'pending'
    },
    addSuccess (state, data) {
      state.status = 'success'
    },
    addError (state, data) {
      state.status = 'error'
    },
  },
  actions: {
    async addAsync ({ commit }, options) {
      commit('addPadding')
      
      Request.post('/expenses/add', options, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('addSuccess')
        } else {
          commit('showToast', {msg: Util.getFirstAttr(data.Data.errors)})
          commit('addError')
        }
      }).catch((e) => {
        commit('showToast', {msg: '新增消费记录失败'})
        commit('addError')
      })
    },
  }
}
