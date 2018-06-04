<template>
  <div class="container">
    <toast />
    <div>

      <div class="weui-cells weui-cells_after-title">
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <div class="weui-label">当前项目</div>
          </div>
          <div class="weui-cell__bd">
            {{trip_name}}
          </div>
        </div>
        <div class="weui-cell">
          <div class="weui-cell__hd">
            <div class="weui-label">经手人</div>
          </div>
          <div class="weui-cell__bd">
            {{handler_name}}
          </div>
        </div>
      </div>

      <div class="weui-cells">
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
            <switch v-if="receipt" @change="switchReceipt" color="#0a9ffd" checked />
            <switch v-else @change="switchReceipt" color="#0a9ffd" />
          </div>
        </div>
        <div class="weui-cell weui-cell_input">
          <div class="weui-cell__bd">
            <input class="weui-input" placeholder="其他备注" v-model="remark" />
          </div>
        </div>
      </div>

      <div class="btn-area">
        <Button type="primary" class="weui-btn" :disabled="status === 'pending'" @click="onEdit">
          修改
        </Button>
        <Button type="warn" class="weui-btn" :disabled="status === 'pending'" @click="onDelete">
          删除
        </Button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Path from '@/config/path'
import Util from '@/utils/util'

import toast from '@/components/toast'

export default {
  components: {
    toast,
  },
  watch: {
    status (status) {
      if (status == 'success') {
        let that = this
        wx.showModal({
          title: '修改成功',
          content: '请返回账单列表查看本次出差的消费明细',
          confirmColor: '#0a9ffd',
          success: function(res) {
            if (res.confirm) {
              that.$router.back()
            }
          }
        })
      }
    },
    deleteStatus (status) {
      if (status == 'success') {
        let that = this
        wx.showModal({
          title: '删除成功',
          content: '返回账单查看本次出差的其他消费',
          confirmColor: '#0a9ffd',
          success: function(res) {
            if (res.confirm) {
              that.$router.back()
            } else {
              that.$router.back()
            }
          }
        })
      }
    }
  },
  data () {
    return {
      trip_name: '',
      handler_name: '',
      category_id: 0,
      date: '',
      item: '',
      city: '',
      money: 0,
      receipt: true,
      remark: '',
    }
  },
  computed: {
    ...mapState({
      status: state => state.edit.status,
      deleteStatus: state => state.edit.deleteStatus,
      orginal: state => state.edit.orginal,
      category: state => state.base.category,
      handler: state => state.base.handler,
      trip: state => state.base.trip,
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
  onShow () {
    let orginal = this.orginal

    this.trip_name = this.trip.find(item => item.id == orginal.expenses_trip).trip_name
    this.handler_name = this.handler.find(item => item.id == orginal.expenses_handler).handler_name
    this.category_id = orginal.expenses_category
    this.date = orginal.expenses_date
    this.item = orginal.expenses_item
    this.city = orginal.expenses_city
    this.money = orginal.expenses_money
    this.receipt = orginal.expenses_receipt == 1
    this.remark = orginal.expenses_remark
  },
  methods: {
    ...mapMutations({
      showToast: 'showToast',
      login: 'login',
      logout: 'logout',
    }),
    ...mapActions({
      editAsync: 'editAsync',
      deleteAsync: 'deleteAsync',
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
    switchReceipt (e) {
      this.receipt = e.mp.detail.value
    },
    onEdit () {
      let that = this
      let category = this.category_id
      let date = this.date
      let item = this.item
      let city = this.city
      let money = this.money
      
      if (!category) {
        that.showToast({msg: '请选择分类'})
        return
      }
      if (!date) {
        that.showToast({msg: '请选择消费时间'})
        return
      }
      if (!money) {
        that.showToast({msg: '请填写消费金额'})
        return
      }

      let options = {
        id: this.orginal.id,
        expenses_item: item,
        expenses_city: city,
        expenses_date: date,
        expenses_category: category,
        expenses_trip: this.orginal.trip_id,
        expenses_handler: this.orginal.handler_id,
        expenses_money: this.money,
        expenses_remark: this.remark,
        expenses_receipt: this.receipt ? 1 : 0,
      }

      this.editAsync(options)
    },
    onDelete () {
      this.deleteAsync({
        id: this.orginal.id
      })
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
.weui-btn{
  margin-top: 8px;
}
</style>
