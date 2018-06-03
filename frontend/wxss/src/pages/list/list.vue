<template>
  <div class="container">
    <noLogin v-if="!isLogin"/>
    <div v-else>
      列表页面
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

import noLogin from '@/components/noLogin'

export default {
  components: {
    noLogin
  },
  computed: {
    ...mapState({
      isLogin: state => state.user.isLogin,
      user: state => state.user.user,
    })
  },
  onShow () {
    // 如果已经登录，修改顶部标题
    if (this.isLogin && this.user.trip_name) {
      wx.setNavigationBarTitle({
        title: this.user.trip_name
      })    
    }
    // 获取第一页数据
    this.initPage()
    this.getListAsync()
  },
  methods: {
    ...mapMutations({
      initPage: 'initPage',
      nextPage: 'nextPage',
    }),
    ...mapActions({
      getListAsync: 'getListAsync',
    }),
  }
}
</script>

<style scoped>
</style>
