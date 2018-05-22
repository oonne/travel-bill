<template>
	<div class="nav-item" :class="{active: active}">
		<slot></slot>
		<p>{{name}}</p>
	</div>
</template>

<script>
export default {
    name: 'bottom-nav-item',
	props: [
		'active',
		'name'
	]
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
	@import "../assets/base.scss";

	.nav-item {
		width: 100%;
		height: 100%;
		text-align: center;
		color: $minorColor;

		.nav-icon{
			display: block;
			margin: 6px auto 0;
			font-size: 24px;
			line-height: 24px;
		}

		p{
			font-size: 12px;
		}
	}
	.active {
		color: $mainColor;
	}
</style>


