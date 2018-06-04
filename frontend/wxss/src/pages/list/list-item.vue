<template>
  <div class="item" @click="toEdit">
    <div class="item_content">
      <div class="expenses_item">
        {{expneses.expenses_item}}
      </div>
      <div class="expenses_info">
        {{expneses.expenses_date}} {{handler}}
      </div>
    </div>
    <div class="money">
      {{expneses.expenses_money}}
    </div>
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
  computed: {
    ...mapState({
      handlerList: state => state.base.handler,
    }),
    handler () {
      let handler = this.handlerList.find(item => item.id==this.expneses.expenses_handler)
      return handler ? handler.handler_name : ''
    }
  },
  methods: {
    ...mapMutations({
      edit: 'edit',
    }),
    toEdit () {
      this.edit(this.expneses)
      this.$router.push(Path.edit)
    }
  }
}
</script>

<style scoped>
.item{
  background-color: #fff;
  margin: 0 8px 6px;
  border-radius: 4px;
  position: relative;
  height: 64px;
}
.item_content{
  width: 100%;
  padding: 6px 92px 6px 14px;
  box-sizing: border-box;
}
.money{
  position: absolute;
  right: 0;
  top: 0;
  bottom: 0;
  height: 64px;
  line-height: 64px;
  width: 88px;
  background-color: #57b6f2;
  color: #fff;
  text-align: center;
  border-radius: 0 4px 4px 0;
}
.expenses_item{
  color: #444;
}
.expenses_info{
  font-size: 0.8em;
  color: #777;
}
</style>
