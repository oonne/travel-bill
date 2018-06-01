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
    	// TODO 新增记账的接口
    },
  }
}
