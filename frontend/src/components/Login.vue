<template>
    <div class="login">
        <div class="logo">
            <svg class="icon logo-bg" aria-hidden="true"><use xlink:href="#icon-hexagon"></use></svg>
            <h1 class="logo-text">FMS</h1>
        </div>
        <div class="form" :class="{shake: error }">
            <input v-model="username" placeholder="帐号">
            <input v-model="password" placeholder="密码">
            <button class="btn-success" @click="login">登录</button>
            <div class="error-msg">{{errorMsg}}</div>
        </div>
    </div>
</template>

<script>
import Base from './Base'

export default {
    extends: Base,
    name: 'login',
    data () {
        return {
            username: '',
            password: '',
        }
    },
    methods: {
        login: function(){
            let vm = this
            if ( !vm.username || !vm.password ) {
                vm.errorMsg = '请填写帐号和密码'
            } else {
                fetch('/api/user/login', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: vm.username,
                        password: vm.password,
                    })
                })
                .then(function (response) {
                    if (response.status == 200) {
                        return response.json()
                    } else {
                        vm.errorMsg = response.statusText
                    }
                })
                .then(function (data) {
                    if (data) {
                        if (data.Ret) {
                            vm.errorMsg = vm.getFirstAttr(data.Data.errors)
                            console.warn(data.Data.errors)
                        } else {
                            localStorage.setItem('user', JSON.stringify(data.Data))
                            vm.$router.push('/')
                        }
                    }
                })
                .catch(function (error) {
                    console.error(error)
                    vm.errorMsg = '服务器故障'
                })
            }
        }
    },
}
</script>

<style lang="scss" scoped>
    @import "../assets/base.scss";

    $logoSize: 120; 
    
    .login {
        width: 100%;

        .logo {
            position: relative;
            margin: 18vh auto 80px;
            width: #{$logoSize}px;
            height: #{$logoSize}px;

            .logo-content{
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
            }

            .logo-text {
                @extend .logo-content;
                display: block;
                color: #fff;
                font-size: 1.6rem;
                line-height: #{$logoSize}px;
                text-align: center;
                font-weight: 400;
            }
            
            .logo-bg {
                @extend .logo-content;
                animation: rotation linear 30s infinite;
                color: #e7604a;
                background-image: linear-gradient(135deg, #e7604a, #de6262);
                -webkit-text-fill-color: transparent;
                -webkit-background-clip: text;
            }
            @keyframes rotation {
                from {
                    transform: rotate(0deg);
                    filter: hue-rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                    filter: hue-rotate(-360deg);
                }
            }
        }

        .form{
            width: 300px;
            margin: auto;

            input {
                display: block;
                width: 100%;
                height: 2.4rem;
                line-height: 1.6rem;
                margin: 20px 0;
                padding: 0.4rem 14px;
                border-radius: 4px;
                border: none;
                background-color: #ddd;
                color: #333;
            }

            .error-msg {
                color: $dangerColor;
                text-align: center;
                font-style: 0.8rem;
            }
        }

    }

</style>
