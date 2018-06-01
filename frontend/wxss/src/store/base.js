

export default {
  state: {
    category: [],
    trip: [],
    handler: [],
  },
  mutations: {
    setCategory (state, data) {
      state.category = data
    },
    setTrip (state, data) {
      state.trip = data
    },
    setHandler (state, data) {
      state.handler = data
    },
  },
  actions: {
  }
}
