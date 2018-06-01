<template>
  <div class="container">
    <toast />
    <noLogin v-if="!isLogin"/>
    <div v-else>

      <div class="weui-cells weui-cells_after-title">
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <div class="weui-label">当前项目</div>
          </div>
          <div class="weui-cell__bd">
            {{user.trip_name}}
          </div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <div class="weui-label">经手人</div>
          </div>
          <div class="weui-cell__bd">
            {{user.handler_name}}
          </div>
        </div>
        <div class="weui-cell weui-cell_select">
          <div class="weui-cell__hd weui-cell__hd_in-select-after">
            <div class="weui-label">分类</div>
          </div>
          <div class="weui-cell__bd">
            <picker :value="categoryIndex" :range="category" range-key="category_name" @change="onChangeCategory">
              <div class="weui-select weui-select_in-select-after">{{categoryVal}}</div>
            </picker>
          </div>
        </div>
        <div class="weui-cell weui-cell_select">
          <div class="weui-cell__hd weui-cell__hd_in-select-after">
            <div class="weui-label">消费时间</div>
          </div>
          <div class="weui-cell__bd">
            <picker mode="date" :value="date" @change="onChangeDate">
              <div class="weui-select weui-select_in-select-after">{{date}}</div>
            </picker>
          </div>
        </div>
        <div class="weui-cell weui-cell_input">
          <div class="weui-cell__hd">
            <div class="weui-label">消费内容</div>
          </div>
          <div class="weui-cell__bd">
            <input class="weui-input" placeholder="消费内容项" v-model="item" />
          </div>
        </div>
        <div class="weui-cell weui-cell_input">
          <div class="weui-cell__hd">
            <div class="weui-label">地点</div>
          </div>
          <div class="weui-cell__bd">
            <input class="weui-input" placeholder="消费的城市" v-model="city" />
          </div>
        </div>
        <div class="weui-cell weui-cell_input">
          <div class="weui-cell__hd">
            <div class="weui-label">金额</div>
          </div>
          <div class="weui-cell__bd">
            <input class="weui-input" type="digit" v-model="money" />
          </div>
        </div>
        <div class="weui-cell weui-cell_switch">
          <div class="weui-cell__bd">
            有无发票
          </div>
          <div class="weui-cell__ft">
            <switch @change="switchReceipt" checked />
          </div>
        </div>
        <div class="weui-cell weui-cell_input">
          <div class="weui-cell__bd">
            <input class="weui-input" placeholder="其他备注" />
          </div>
        </div>
      </div>

      <div class="btn-area">
        <Button type="primary" class="weui-btn" :disabled="status === 'pending'" @click="onAdd">
          记一笔
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'
import Util from '@/utils/util'

import noLogin from '@/components/noLogin'
import toast from '@/components/toast'

export default {
  components: {
    noLogin,
    toast,
  },
  watch: {
    category (category) {
      // 加载完分类列表之后默认加载第一个
      this.category_id = category[0].id
    }
  },
  data () {
    return {
      category_id: 0,
      item: '',
      city: '',
      money: 0,
      date: '',
      receipt: true,
    }
  },
  computed: {
    ...mapState({
      status: state => state.add.status,
      isLogin: state => state.user.isLogin,
      user: state => state.user.user,
      category: state => state.base.category,
    }),
    categoryIndex () {
      let category_id = this.category_id
      let index = this.category.findIndex(item => item.id === category_id)
      return index
    },
    categoryVal () {
      let category_id = this.category_id
      let category = this.category.find(item => item.id === category_id)
      if (!category) {
        return '请选择'
      }
      return category.category_name
    }
  },
  created () {
    this.date = Util.getYYYYMMDD(new Date())
  },
  methods: {
    ...mapMutations({
      showToast: 'showToast',
    }),
    onChangeCategory (e) {
      let index = e.mp.detail.value
      let id = this.category[index].id
      this.category_id = id
    },
    onChangeDate (e) {
      let date = e.mp.detail.value
      this.date = date
    },
    onAdd () {
      let that = this
      let category = this.category_id
      
      if (!category) {
        that.showToast({msg: '请选择分类'})
        return
      }
      console.log(this.date)
    },
    switchReceipt (e) {
      this.receipt = e.mp.detail.value
    }
  }
}
</script>

<style scoped>
.weui-cells{
  width: 100%;
}
.btn-area{
  width: 100%;
  box-sizing: border-box;
  padding: 10px;
}
</style>
