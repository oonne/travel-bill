import Vue from 'vue'
import Vuex from 'vuex'

import homeApp from './homeApp'
Vue.use(Vuex)

let store = new Vuex.Store({
  modules: {
    homeApp: homeApp
  }
})

export default store
