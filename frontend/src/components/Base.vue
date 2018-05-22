<template></template>

<script>
export default {
    name: 'base',
    data () {
        return {
            token: '',
            pageCount: 1,   //总页数
            currentPage: 1, //当前页数
            loading: true,  //加载中
            error: false,   //错误
            errorMsg: '',   //错误提示
            toast: false,   //气泡
            toastMsg: '',   //气泡提示
        }
    },
    methods: {
        getFirstAttr: function(object) {
            for (let i in object) return object[i]
        },
        checkScrollEnd: function(){
            let scrollTop = Math.max(document.body.scrollTop, document.documentElement.scrollTop)
            let scrollHeight = document.documentElement.scrollHeight
            return (scrollHeight-scrollTop<1100)
        },
        getUser: function(callback){
            if(localStorage.getItem( 'user' )){
                let user = eval('('+localStorage.getItem('user')+')')
                this.token = user.access_token
                if (typeof callback == 'function') return callback(user)
            }else{
                this.noLog()
            }   
        },
        getToday: function(){
            let date = new Date()
            let y = date.getFullYear()
            let m = date.getMonth()+1
            let d = date.getDate()
            if (m >= 1 && m <= 9) {
                m = "0" + m
            }
            if (d >= 1 && d <= 9) {
                d = "0" + d
            }
            return y+"-"+m+"-"+d
        },
        noLog: function(){
            this.$router.push('/login')
        },
    },
    watch: {
        errorMsg: function () {
            let vm = this
            if (vm.errorMsg) {
                vm.error = true
            } else {
                vm.error = false
            }
        },
        toastMsg: function () {
            let vm = this
            if (vm.toastMsg) {
                vm.toast = true    
                setTimeout(function(){
                    vm.toast = false
                }, 1000)
                setTimeout(function(){
                    vm.toastMsg = ''
                }, 1500)
            }
        },
    },
}
</script>

<style lang="scss" scoped></style>
