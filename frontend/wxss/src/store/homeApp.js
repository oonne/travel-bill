export default {
  state: {
  	'test': ''
  },
  mutations: {
  	on (state, data) {
      state.test = 'on'
    },
  	off (state, data) {
      state.test = 'off'
    },
  },
  actions: {
  }
}
