import Request from '../utils/request'
import Util from '../utils/util'
import Url from '../config/url'

export default {
  state: {
  	status: '',
    list: [],
    pageCount: 1, //总页数
    currentPage: 1, //当前页数
  },
  mutations: {
    sraechPadding (state, data) {
      state.status = 'pending'
    },
    sraechSuccess (state, data) {
      state.status = 'success'
    },
    sraechError (state, data) {
      state.status = 'error'
    },
    initPage (state, data) {
      state.list = []
      state.currentPage = 1

    }, 
    nextPage (state, data) {
      state.currentPage++
    }, 
  },
  actions: {
    async getListAsync ({ commit, state }, options) {
      commit('sraechPadding')

      let reqParams = {
        page: state.currentPage
      }
      
      Request.get('/expenses/index', reqParams, {
        baseURL: Url.api
      }).then((data) => {
        if (data.Ret == 0) {
          commit('sraechSuccess')
          console.log(data.Data)
        } else {
          commit('showToast', {msg: '查询失败'})
          commit('sraechError')
        }
      }).catch((e) => {
        commit('showToast', {msg: '查询失败'})
        commit('sraechError')
      })
    },
  }
}
