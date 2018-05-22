<template>
    <div class="user">
        <BottomNav active='user' />

        <div class="user-info">
            {{nickname}}
        </div>
        <div class="btn-danger" @click="logout">退出登录</div>
    </div>
</template>

<script>
import Base from './Base'
import BottomNav from './BottomNav'

export default {
    extends: Base,
    name: 'user',
    components: {
        'BottomNav': BottomNav,
    },
    data () {
        return {
            nickname: ''
        }
    },
    created: function () {
        let vm = this
        this.getUser(function(user){
            vm.nickname = user.nickname
        })
    },
    methods: {
        logout: function(){
            localStorage.clear()
            sessionStorage.clear()
            this.noLog()
        },
    },
}
</script>

<style lang="scss" scoped>
    @import "../assets/base.scss";

    .user {
        padding: 20px 10px #{($bottomNavHeight)+10}px 10px;

        .user-info {
            @extend .card;
            height: 60px;
            line-height: 60px;
            text-align: center;
        }   
    }

</style>


