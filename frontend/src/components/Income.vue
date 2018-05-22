<template>
    <div class="income-list">
        <ErrorBar :text="errorMsg" />
        <BottomNav active='income' />

        <div @click="addOn" class="add-income" :class="{'adding-income': (editingIndex=='new')}">
            <div class="add-button">+</div>
            <div class="edit">
                <div class="money_handler_item" :class="'color-'+editingIncome.income_handler">
                    <div class="money">
                        <input v-model.number="editingIncome.income_money" @blur="formatMoney">
                    </div>
                    <div class="handler" @click.stop="changeHandler">
                        {{getHandlerName(editingIncome.income_handler)}}
                    </div>
                    <div class="item">
                        <input v-model.trim="editingIncome.income_item" placeholder="内容">
                    </div>
                </div>
                <div class="date">
                    <input type="date" v-model="editingIncome.income_date">
                </div>
                <div class="remark">
                    <input v-model.trim="editingIncome.income_remark" placeholder="备注">
                </div>
                <div class="income-btn-list">
                    <div class="income-btn-delete" @click.stop="editingIndex = null">取消</div>
                    <div class="income-btn-save" :class="{ 'income-btn-disable': !editingIncome.income_item }" @click.stop="addSave">保存</div>
                </div>
            </div>
        </div>
        <ul>
            <li v-for="(income, index) in incomeList" @click="editingOn(index)" :class="{ 'editing': (index==editingIndex) }">
                <div class="info">
                    <p class="item">{{income.income_item}}</p>
                    <p class="date_handler">{{income.income_date}} {{getHandlerName(income.income_handler)}}</p>
                </div>
                <div class="money" :class="'color-'+income.income_handler">{{income.income_money}}</div>
            
                <div class="edit">
                    <div class="money_handler_item" :class="'color-'+editingIncome.income_handler">
                        <div class="money">
                            <input v-model.number="editingIncome.income_money" @blur="formatMoney">
                        </div>
                        <div class="handler" @click.stop="changeHandler">
                            {{getHandlerName(editingIncome.income_handler)}}
                        </div>
                        <div class="item">
                            <input v-model.trim="editingIncome.income_item">
                        </div>
                    </div>
                    <div class="date">
                        <input type="date" v-model="editingIncome.income_date">
                    </div>
                    <div class="remark">
                        <input v-model.trim="editingIncome.income_remark" placeholder="备注">
                    </div>
                    <div class="income-btn-list">
                        <div class="income-btn-delete" @click.stop="deleteIncome">删除</div>
                        <div class="income-btn-save" :class="{ 'income-btn-disable': !editingIncome.income_item }" @click.stop="saveIncome">保存</div>
                    </div>
                </div>
            </li>
        </ul>
        <LoadMore v-show="loading"/>        
    </div>
</template>

<script>
import Base from './Base'
import BottomNav from './BottomNav'
import ErrorBar from './ErrorBar'
import LoadMore from './LoadMore'

export default {
    extends: Base,
    name: 'income',
    components: {
        'BottomNav': BottomNav,
        'ErrorBar': ErrorBar,
        'LoadMore': LoadMore,
    },
    data () {
        return {
            incomeList: [],
            handlerList: [],
            editingIndex: null,
            editingIncome: {
                'id': null,
                'income_date': null,
                'income_item': '',
                'income_money': 0,
                'income_handler': null,
                'income_remark': '',
            },
        }
    },
    created: function () {
        this.getUser(this.init)
    },
    methods: {
        init: function () {
            let vm = this
            vm.getList()
            window.addEventListener('scroll', vm.handleScroll)
        },
        getList: function () {
            let vm = this
            fetch('/api/income/index?page='+vm.currentPage, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Auth-Token': vm.token
                }
            })
            .then(function (response) {
                if (response.status == 200) {
                    return response.json()
                } else if (response.status == 401) {
                    vm.errorMsg = '未登录'
                    vm.noLog()
                } else {
                    vm.errorMsg = response.statusText
                }
            })
            .then(function (data) {
                vm.loading = false
                if (data) {
                    if (!data.Ret) {
                        vm.pageCount = data.Meta.pageCount
                        vm.currentPage = data.Meta.currentPage
                        vm.handlerList = data.Extra.handler
                        vm.incomeList = vm.incomeList.concat(data.Data)
                    } else {
                        vm.errorMsg = vm.getFirstAttr(data.Data.errors)
                        console.warn(data.Data.errors)
                    }
                }
            })
            .catch(function (error) {
                vm.loading = false
                console.error(error)
                vm.errorMsg = '服务器故障'
            })
        },
        handleScroll: function(){
            let vm = this
            if(vm.checkScrollEnd() && !vm.loading){
                if(vm.pageCount>vm.currentPage){
                    vm.currentPage++;
                    vm.loading = true;
                    vm.getList()
                }
            }
        },
        getHandlerName: function (id) {
            let vm = this
            let name = ''
            for (let handler of vm.handlerList) {
                if (handler.id == id) {
                    name = handler.handler_name
                }
            }
            return name
        },
        addOn: function(index){
            let vm = this
            if (vm.editingIndex === null) {
                vm.editingIndex = 'new'
                vm.editingIncome = {
                    'income_date': vm.getToday(),
                    'income_item': '',
                    'income_money': 0,
                    'income_handler': vm.handlerList[0].id,
                    'income_remark': '',
                }
            }
        },
        addSave: function(){
            let vm = this
            if (vm.editingIndex != null && vm.editingIncome.income_item) {
                let income = JSON.stringify(vm.editingIncome)
                vm.loading = true
                fetch('/api/income/add', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Auth-Token': vm.token
                    },
                    body: income
                })
                .then(function (response) {
                    if (response.status == 200) {
                        return response.json()
                    } else if (response.status == 401) {
                        vm.errorMsg = '未登录'
                        vm.noLog()
                    } else {
                        vm.errorMsg = response.statusText
                    }
                })
                .then(function (data) {
                    vm.loading = false
                    if (data) {
                        if (!data.Ret) {
                            vm.incomeList.unshift(vm.editingIncome)
                            vm.editingIndex = null
                        } else {
                            vm.errorMsg = vm.getFirstAttr(data.Data.errors)
                            console.warn(data.Data.errors)
                        }
                    }
                })
                .catch(function (error) {
                    vm.loading = false
                    console.error(error)
                    vm.errorMsg = '服务器故障'
                })
            }
        },
        editingOn: function(index){
            let vm = this
            if (vm.editingIndex === null) {
                let income = vm.incomeList[index]
                vm.editingIndex = index
                vm.editingIncome = income
            }
        },
        changeHandler: function(){
            let vm = this
            if (vm.editingIndex != null) {
                let id = 0
                for (let i in vm.handlerList) {
                    if (vm.handlerList[i].id == vm.editingIncome.income_handler) {
                        if (parseInt(i)+1<vm.handlerList.length) {
                            id = vm.handlerList[parseInt(i)+1].id
                        } else {
                            id = vm.handlerList[0].id
                        }
                    }
                }
                vm.editingIncome.income_handler = id
            }
        },
        formatMoney: function() {
            this.editingIncome.income_money = this.editingIncome.income_money.toFixed(2)
        },
        deleteIncome: function() {
            let vm = this
            if (vm.editingIndex != null) {
                vm.loading = true
                fetch('/api/income/delete', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Auth-Token': vm.token
                    },
                    body: JSON.stringify({'id': vm.editingIncome.id})
                })
                .then(function (response) {
                    if (response.status == 200) {
                        return response.json()
                    } else if (response.status == 401) {
                        vm.errorMsg = '未登录'
                        vm.noLog()
                    } else {
                        vm.errorMsg = response.statusText
                    }
                })
                .then(function (data) {
                    vm.loading = false
                    if (data) {
                        if (!data.Ret) {
                            console.log('OK')
                            vm.incomeList.splice(vm.editingIndex, 1)
                            vm.editingIndex = null
                        } else {
                            vm.errorMsg = vm.getFirstAttr(data.Data.errors)
                            console.warn(data.Data.errors)
                        }
                    }
                })
                .catch(function (error) {
                    vm.loading = false
                    console.error(error)
                    vm.errorMsg = '服务器故障'
                })
            }
        },
        saveIncome: function() {
            let vm = this
            if (vm.editingIndex != null && vm.editingIncome.income_item) {
                let income = JSON.stringify(vm.editingIncome)
                vm.loading = true
                fetch('/api/income/update', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Auth-Token': vm.token
                    },
                    body: income
                })
                .then(function (response) {
                    if (response.status == 200) {
                        return response.json()
                    } else if (response.status == 401) {
                        vm.errorMsg = '未登录'
                        vm.noLog()
                    } else {
                        vm.errorMsg = response.statusText
                    }
                })
                .then(function (data) {
                    vm.loading = false
                    if (data) {
                        if (!data.Ret) {
                            vm.incomeList[vm.editingIndex] = vm.editingIncome
                            vm.editingIndex = null
                        } else {
                            vm.errorMsg = vm.getFirstAttr(data.Data.errors)
                            console.warn(data.Data.errors)
                        }
                    }
                })
                .catch(function (error) {
                    vm.loading = false
                    console.error(error)
                    vm.errorMsg = '服务器故障'
                })
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    @import "../assets/base.scss";

    .color-1{
        background-color: $colorA;
    }
    .color-2{
        background-color: $colorB;
    }
    .color-3{
        background-color: $colorC;
    }
    .color-4{
        background-color: $colorD;
    }

    $itemHeight: 64;
    $itemEditingHeight: 276;

    .income-edit {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: #{$itemEditingHeight}px;
        opacity: 0;
        transition: opacity .3s;
        background-color: #fff;

        input {
            border: none;
            background:transparent;
        }

        .money_handler_item{
            height: 124px;
            padding: 0 30px;
            transition: background-color .3s;

            .money {
                width: 70%;
                height: 64px;
                float: left;
                overflow: hidden;
                
                input {
                    color: #fff;
                    font-size: 2rem;   
                    height: 64px;   
                    line-height: 40px;
                    padding: 12px 2px;
                }
            }
            .handler {
                width: 30%;
                float: right;
                text-align: right;
                color: #fff;
                line-height: 64px;
                font-size: 0.9rem;
            }
            .item {
                clear: both;
                width: 100%;
                height: 60px;
                border-top: 2px dashed #fff;

                input {
                    width: 100%;
                    text-align: center;
                    color: #fff;   
                    font-size: 1.1rem;   
                    height: 60px;
                    line-height: 36px;
                    padding: 12px 2px;
                }
                input::-webkit-input-placeholder {
                    color: #dfdfdf;
                }
            }
        }
        .date {
            padding: 0 30px;
            height: 56px;
            width: 100%;

            input {
                height: 56px;
                line-height: 56px;
                border: none;
                background:transparent;
                color: #777;
            }
        }
        .remark {
            position: relative;
            padding: 0 30px 10px;
            height: 54px;
            width: 100%;

            input {
                height: 44px;
                width: 100%;
                padding: 12px 0;
                line-height: 20px;
                border: none;
                background:transparent;
                color: #777;
            }
        }
        .remark:after {
            @extend .line-bottom;
        }

        .income-btn-list {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: space-between;

            .income-btn {
                width: 50%;
                height: 50px;
                line-height: 50px;
                text-align: center;
            }
            .income-btn-delete {
                @extend .income-btn;
                color: $dangerColor;
            }
            .income-btn-save {
                @extend .income-btn;
                position: relative;
                color: #333;
            }
            .income-btn-save:after {
                @extend .line-left;
            }
            .income-btn-disable {
                color: #999;
            }
        }
    }

    .income-list {
        padding: 10px 10px #{($bottomNavHeight)+10}px 10px;
        
        .add-income {
            transition: height .3s;
            height: #{$itemHeight}px;
            overflow: hidden;
            margin-bottom: 10px;
            position: relative;

            .add-button {
                width: 100%;
                height: 100%;
                border-radius: 3px;
                border: 2px dashed #bbb;
                text-align: center;
                line-height: #{($itemHeight)-4}px;
                color: #bbb;
                font-size: 2rem;
            }
            .edit {
                @extend .income-edit;
            }
        }
        .adding-income {
            height: #{$itemEditingHeight}px;

            .edit {
                opacity: 1;
            }
        }

        ul {
            li {
                @extend .card;
                position: relative;
                height: #{$itemHeight}px;
                transition: height .3s;
                height: #{$itemHeight}px;
                margin-bottom: 10px;
                display: flex;

                .info {
                    flex: 1 1 100%;
                    height: #{$itemHeight}px;
                    padding: 10px;

                    .item {
                        color: #666;
                    }
                    .date_handler {
                        color: #aaa;
                        font-size: 0.8rem;
                    }
                }

                .money {
                    flex: 0 0 80px;
                    width: 80px;
                    height: #{$itemHeight}px;
                    line-height: #{$itemHeight}px;
                    color: #fff;
                    text-align: center;
                }

                .edit {
                    @extend .income-edit;
                }
            }

            .editing {
                height: #{$itemEditingHeight}px;

                .edit {
                    opacity: 1;
                }
            }
        }
    }

</style>


