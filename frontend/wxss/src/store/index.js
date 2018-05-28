import Vue from 'vue'
import Vuex from 'vuex'

import login from './login'
import homeApp from './homeApp'
Vue.use(Vuex)

let store = new Vuex.Store({
  modules: {
    login: login,
    homeApp: homeApp
  }
})

export default store
