<template>
  <div class="container">
    <noLogin v-if="!isLogin"/>
    <div v-else class="list">
      <empty v-if="pageCount==0"/>
      <listItem
        v-for="item of list"
        :key="item.id"
        :expneses="item"
      />

      <div class="weui-loadmore" v-show="status=='pending'">
          <div class="weui-loading"></div>
          <div class="weui-loadmore__tips">加载中...</div>
      </div>

      <div class="weui-loadmore weui-loadmore_line" v-show="pageCount==currentPage">
          <div class="weui-loadmore__tips weui-loadmore__tips_in-line">END</div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'

import noLogin from '@/components/noLogin'
import listItem from './list-item'
import empty from './empty'

export default {
  components: {
    noLogin,
    listItem,
    empty,
  },
  computed: {
    ...mapState({
      isLogin: state => state.user.isLogin,
      user: state => state.user.user,
      status:  state => state.list.status,
      list:  state => state.list.list,
      pageCount:  state => state.list.pageCount,
      currentPage:  state => state.list.currentPage,
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
  onPullDownRefresh () {
    // 获取第一页数据
    this.initPage()
    this.getListAsync()
  },
  onReachBottom () {
    // 如果还有下一页，则刷新下一页
    if (this.currentPage < this.pageCount) {
      this.nextPage()
      this.getListAsync()
    }
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
.list{
  padding: 6px 0;
}
</style>
