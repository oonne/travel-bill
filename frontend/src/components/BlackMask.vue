<template>
	<div class="black-mask" :style="{ 'z-index': z }" @click="click">
		<slot></slot>
	</div>
</template>

<script>
export default {
    name: 'black-mask',
	props: {
		'z': {
	    	type: Number,
			default: 60
		}
	},
	methods: {
		click: function () {
			this.$emit('click')
		}
	}
}
</script>

<style lang="scss" scoped>
	@import "../assets/base.scss";

	.black-mask {
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		margin: auto;
		background: rgba(0, 0, 0, .6);
	}
</style>


