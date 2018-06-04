import Request from '../utils/request'
import Util from '../utils/util'
import Url from '../config/url'

export default {
  state: {
    orginal: null,
    status: '',
  	deleteStatus: '',
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
    deletePadding (state, data) {
      state.deleteStatus = 'pending'
    },
    deleteSuccess (state, data) {
      state.deleteStatus = 'success'
    },
    deleteError (state, data) {
      state.deleteStatus = 'error'
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
    async deleteAsync ({ commit }, options) {
      commit('deletePadding')
      
      Request.post('/expenses/delete', options, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('deleteSuccess')
        } else {
          commit('showToast', {msg: Util.getFirstAttr(data.Data.errors)})
          commit('deleteError')
        }
      }).catch((e) => {
        commit('showToast', {msg: '删除失败'})
        commit('deleteError')
      })
    },
  }
}
