<template>
  <div class="item">
    {{expneses.expenses_money}}
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

export default {
  props: {
    expneses: {
      type: Object,
      default () {
        return {}
      }
    },
  },
  methods: {

  }
}
</script>

<style scoped>
.item{
  background-color: #fff;
  margin: 0 8px 6px;
  padding: 10px 20px;
  border-radius: 4px;
}
</style>
