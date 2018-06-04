import Vue from 'vue'
import Vuex from 'vuex'

import toast from './toast'
import base from './base'
import user from './user'
import add from './add'
import edit from './edit'
import list from './list'
Vue.use(Vuex)

let store = new Vuex.Store({
  modules: {
    toast: toast,
    base: base,
    user: user,
    add: add,
    edit: edit,
    list: list,
  }
})

export default store
