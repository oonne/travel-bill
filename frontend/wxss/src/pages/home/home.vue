<template>
  <div class="container">
    {{motto}}
    <input v-model="motto" />
    {{test}}
    <button @click="on">on</button>
    <button @click="off">off</button>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  data () {
    return {
      motto: 'Hello World',
    }
  },
  computed: {
    ...mapState({
      test: state => state.homeApp.test,
    })
  },
  methods: {
    ...mapMutations({
      on: 'on',
      off: 'off',
    }),
  }
}
</script>

<style scoped>
</style>
