<template>
    <div id="app">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'app'
}
</script>

<style lang="scss">
    @import "assets/base.scss";

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-size: 16px;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    }
    a {
        text-decoration: none;
    }
    li {
        list-style-type: none;
    }
    input,select,button{
        -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
        outline: 0;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        -webkit-user-modify: read-write-plaintext-only;
    }
    html,body{
    	background-color: #eee;
        width: 100%;
        min-height: 100%;
        font-size: 16px;
        font-family: -apple-system-font, "Helvetica Neue", sans-serif;
        line-height: 1.6;
    }
    .icon {
       width: 1em; height: 1em;
       vertical-align: -0.15em;
       fill: currentColor;
       overflow: hidden;
    }
</style>
