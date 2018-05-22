<template>
	<div class="load">
		<i></i>
	</div>
</template>

<script>
export default {
    name: 'load-more',
}
</script>

<style lang="scss" scoped>
	@import "../assets/base.scss";

	.load {
		margin: 6px auto;
		position: relative;
	    width: 1.6rem;
	    height: 1.6rem;
	    border-radius: 50%;
	    box-shadow: inset 0 0 0 .1rem $minorColor;


		i {
			position: absolute;
		    clip: rect(0, 1.6rem, 1.6rem, .8rem);
		    width: 1.6rem;
		    height: 1.6rem;
		    animation: load-circle-clipper 1s ease-in-out infinite;
		}
		i:after {
		    position: absolute;
		    clip: rect(0, 1.6rem, 1.6rem, .8rem);
		    width: 1.6rem;
		    height: 1.6rem;
		    content: '';
		    animation: load-circle 1s ease-in-out infinite;
		    border-radius: 50%;
		    box-shadow: inset 0 0 0 .1rem $mainColor;
		}

		@keyframes load-circle-clipper {
		    0% {
		        transform: rotate(0deg);
		    }

		    100% {
		        transform: rotate(180deg);
		    }
		}
		@keyframes load-circle {
		    0% {
		        transform: rotate(-180deg);
		    }

		    100% {
		        transform: rotate(180deg);
		    }
		}
	}
</style>


