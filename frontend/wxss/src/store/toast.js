export default {
  state: {
    show: false,
    msg: ''
  },
  mutations: {
    showToast (state, data) {
      state.show = true
      state.msg = data.msg
    },
    hideToast (state, data) {
      state.show = false
    }
  },
  actions: {
  }
}
