<template>
	<div class="error-bar" v-if="text">
		{{text}}
	</div>
</template>

<script>
import Base from './Base';

export default {
    extends: Base,
    name: 'error-bar',
	props: {
		'text': {
	    	type: String,
			default: '出错'
		}
	}
}
</script>

<style lang="scss" scoped>
	@import "../assets/base.scss";

	.error-bar {
		position: fixed;
		z-index: 100;
		width: 100%;
		top: 0;
		left: 0;
		right: 0;
		margin: auto;
		padding: 5px;
		background: rgba(191, 19, 19, .9);
		font-size: 14px;
		color: #fff;
	}
</style>


