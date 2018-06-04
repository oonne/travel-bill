import Request from '../utils/request'
import Util from '../utils/util'
import Url from '../config/url'

export default {
  state: {
    orginal: null,
  	status: ''
  },
  mutations: {
    edit (state, data) {
      state.orginal = data
    },
    editPadding (state, data) {
      state.status = 'pending'
    },
    editSuccess (state, data) {
      state.status = 'success'
    },
    editError (state, data) {
      state.status = 'error'
    },
  },
  actions: {
    async editAsync ({ commit }, options) {
      commit('editPadding')
      
      Request.post('/expenses/update', options, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('editSuccess')
        } else {
          commit('showToast', {msg: Util.getFirstAttr(data.Data.errors)})
          commit('editError')
        }
      }).catch((e) => {
        commit('showToast', {msg: '修改失败'})
        commit('editError')
      })
    },
  }
}
