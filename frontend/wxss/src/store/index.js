import Vue from 'vue'
import Vuex from 'vuex'

import toast from './toast'
import user from './user'
import home from './home'
Vue.use(Vuex)

let store = new Vuex.Store({
  modules: {
    toast: toast,
    user: user,
    home: home
  }
})

export default store
