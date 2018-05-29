import Vue from 'vue'
import Vuex from 'vuex'

import toast from './toast'
import login from './login'
import homeApp from './homeApp'
Vue.use(Vuex)

let store = new Vuex.Store({
  modules: {
    toast: toast,
    login: login,
    homeApp: homeApp
  }
})

export default store
