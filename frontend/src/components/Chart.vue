<template>
    <div>
        <BottomNav active='chart' />
        <LoadMore v-show="loading"/> 

        <div class="chart" v-show="chartData">
            <div class="summary">
                <div class="summary-income">
                    <div class="summary-attr">总收入</div>
                    <div class="summary-num">{{chartData ? chartData.incomeTotal : 0}}</div>
                </div>
                <div class="summary-expenses">
                    <div class="summary-attr">总支出</div>
                    <div class="summary-num">{{chartData ? chartData.expensesTotal : 0}}</div>
                </div>
                <div class="summary-balance">
                    <div class="summary-attr">结余</div>
                    <div class="summary-num">{{summaryBalance}}</div>
                </div>
            </div>

            <div class="chart-table">
                <h2>每月收支</h2>
                <div id="monthly" class="chart-content" :style="chartTableStyle"></div>
            </div>
            <div class="chart-table">
                <h2>每月结余</h2>
                <div id="balance" class="chart-content" :style="chartTableStyle"></div>
            </div>
            <div class="chart-pie">    
                <h2>消费分类</h2>
                <div id="category" class="chart-content" :style="chartPieStyle"></div>
            </div>
            <div class="chart-pie">
                <h2>存钱比例</h2>
                <div id="handler" class="chart-content" :style="chartPieStyle"></div>
            </div>
        </div>
    </div>
</template>

<script>
import Base from './Base'
import BottomNav from './BottomNav'
import LoadMore from './LoadMore'
import echarts from '../assets/echarts.js'

export default {
    extends: Base,
    name: 'chart',
    components: {
        'BottomNav': BottomNav,
        'LoadMore': LoadMore,
    },
    data () {
        return {
            chartData: null
        }
    },
    computed: {
        summaryBalance: function () {
            let vm = this
            if (vm.chartData) {
                let balance = (Math.round(vm.chartData.incomeTotal*100-vm.chartData.expensesTotal*100)/100).toFixed(2)
                return balance
            } else {
                return 0
            }
        },
        chartTableStyle: function () {
            let width = document.documentElement.clientWidth - 20
            return 'width: '+width+'px'
        },
        chartPieStyle: function () {
            let width = document.documentElement.clientWidth - 20
            width = width>372 ? 372 : width
            return 'width: '+width+'px;'+'margin-top: -50px'
        },
    },
    created: function () {
        this.getUser(this.init)
    },
    methods: {
        init: function () {
            let vm = this
            fetch('/api/chart/index', {
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
                        vm.showChart(data.Data)
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
        showChart: function(data){
            let vm = this
            vm.chartData = data

            // monthly expenses & monthly income
            let monthChart = echarts.init(document.getElementById('monthly'))
            monthChart.setOption({
                color: ['#72a4bb', '#add536'],
                grid: {
                    left: '2%',
                    right: '6%',
                    top: '10%',
                    containLabel: true
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['月存钱', '月消费']
                },
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap: false,
                        data: data['month']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                dataZoom: [
                    {
                        type: 'inside',
                        start: 0,
                        end: 100
                    },
                ],
                series : [
                    {
                        name: '月消费',
                        type: 'line',
                        data: data['monthlyExpenses'],
                        markLine: {
                            data: [
                                {type: 'average', name: '平均消费'}
                            ],
                            label: {
                                normal: {
                                    position: 'middle'
                                }
                            }
                        }
                    },
                    {
                        name: '月存钱',
                        type: 'line',
                        data: data['monthlyIncome'],
                        markLine: {
                            data: [
                                {type: 'average', name: '平均消费'}
                            ],
                            label: {
                                normal: {
                                    position: 'middle'
                                }
                            }
                        }
                    }
                ]
            }, true)

            // monthly balance
            let balanceChart = echarts.init(document.getElementById('balance'))
            balanceChart.setOption({
                color: ['#ccd539'],
                grid: {
                    left: '2%',
                    right: '6%',
                    top: '2%',
                    containLabel: true
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['月存钱', '月消费']
                },
                xAxis : [
                    {
                        type : 'category',
                        data: data['month']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                dataZoom: [
                    {
                        type: 'inside',
                        start: 0,
                        end: 100
                    },
                ],
                series : [
                    {
                        name: '每月结余',
                        type: 'bar',
                        barWidth: '60%',
                        label: {
                            normal: {
                                position: 'top',
                                show: true
                            }
                        },
                        data: data['monthlyBalance']
                    }
                ]
            }, true)

            // expenses category
            let categoryChart = echarts.init(document.getElementById('category'))
            categoryChart.setOption({
                color: ['#a0c824', '#72a4bb', '#6c6669'],
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },
                series : [
                    {
                        name: '金额',
                        type: 'pie',
                        radius: ['48%', '60%'],
                        data: data['expensesCategory']
                    }
                ]
            }, true)

            // income handler
            let handlerChart = echarts.init(document.getElementById('handler'))
            handlerChart.setOption({
                color: ['#a0c824', '#72a4bb', '#6c6669'],
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                },
                series : [
                    {
                        name: '金额',
                        type: 'pie',
                        radius: ['48%', '60%'],
                        data: data['incomeHandler']
                    }
                ]
            }, true)
        }
    }
}
</script>

<style lang="scss" scoped>
    @import "../assets/base.scss";

    .chart {
        padding: 10px 10px #{($bottomNavHeight)+10}px 10px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        text-align: center;

        .summary {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;

            .summary-item {
                color: #fff;
                margin: 0 5px 20px;
                padding: 10px 16px;
                border-radius: 3px;
                width: 30%;
                min-width: 120px;

                .summary-attr{
                    line-height: 1rem;
                    font-size: 0.8rem;
                    color: #fff;
                }
                .summary-num{
                    line-height: 1.6rem;
                    font-size: 1.2rem;
                    color: #fff;
                }
            }
            .summary-income {
                @extend .summary-item;
                background-color: $colorA;
            }
            .summary-expenses {
                @extend .summary-item;
                background-color: $colorB;
            }
            .summary-balance {
                @extend .summary-item;
                background-color: $colorE;
            }
        }
            
        $chartHeirht: 372;
        .chart-table {
            width: 100%;
            height: #{$chartHeirht}px;
        }
        .chart-pie {
            width: #{$chartHeirht}px;
            height: #{$chartHeirht}px;
            margin-bottom: -50px;
        }
        .chart-content {
            height: #{$chartHeirht}px;
            margin: auto;
        }
        h2 {
            color: #555;
            font-weight: 400;
            font-size: 1.2rem;
        }
    }
</style>


