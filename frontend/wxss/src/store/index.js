import Vue from 'vue'
import Vuex from 'vuex'

import toast from './toast'
import login from './login'
import home from './home'
Vue.use(Vuex)

let store = new Vuex.Store({
  modules: {
    toast: toast,
    login: login,
    home: home
  }
})

export default store
