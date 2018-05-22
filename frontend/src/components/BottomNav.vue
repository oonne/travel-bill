<template>
    <div class="nav">
    	<router-link :to="{ name: 'Expenses'}">
	    	<BottomNavItem v-bind:active="active == 'expenses'" name='消费'>
	    		<svg class="icon nav-icon" aria-hidden="true">
	    			<use v-if="active == 'expenses'" xlink:href="#icon-expenses-fill"></use>
	    			<use v-else xlink:href="#icon-expenses"></use>
	    		</svg>
			</BottomNavItem>
		</router-link>
    	<router-link :to="{ name: 'Income'}">
	    	<BottomNavItem v-bind:active="active == 'income'" name='收入'>
	    		<svg class="icon nav-icon" aria-hidden="true">
	    			<use v-if="active == 'income'" xlink:href="#icon-income-fill"></use>
	    			<use v-else xlink:href="#icon-income"></use>
	    		</svg>
			</BottomNavItem>
		</router-link>
    	<router-link :to="{ name: 'Chart'}">
	    	<BottomNavItem v-bind:active="active == 'chart'" name='统计'>
	    		<svg class="icon nav-icon" aria-hidden="true">
	    			<use v-if="active == 'chart'" xlink:href="#icon-chart-fill"></use>
	    			<use v-else xlink:href="#icon-chart"></use>
	    		</svg>
			</BottomNavItem>
		</router-link>
    	<router-link :to="{ name: 'User'}">
	    	<BottomNavItem v-bind:active="active == 'user'" name='设置'>
	    		<svg class="icon nav-icon" aria-hidden="true">
	    			<use v-if="active == 'user'" xlink:href="#icon-user-fill"></use>
	    			<use v-else xlink:href="#icon-user"></use>
	    		</svg>
			</BottomNavItem>
		</router-link>
    </div>
</template>

<script>
import BottomNavItem from './BottomNavItem'

export default {
    name: 'bottom-nav',
	props: ['active'],
    components: {
        'BottomNavItem': BottomNavItem
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
	@import "../assets/base.scss";

	.nav {
		position: fixed;
		display: flex;
		width: 100%;
		height: #{$bottomNavHeight}px;
		bottom: 0;
		left: 0;
		right: 0;
		margin: auto;
		background-color: #fff;
		z-index: 40;

		a {
			display: block;
			width: 25%;
			height: 100%;
		}
	}
	.nav:before {
		@extend .line-top;
	}
</style>


