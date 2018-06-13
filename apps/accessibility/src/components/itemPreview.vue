<template>
	<div class="preview">
		<div class="preview-image" :style="{backgroundImage: preview.img}"></div>
		<h3>{{preview.title}}</h3>
		<p>{{preview.text}}</p>
	</div>
</template>

<script>
export default {
	name: 'itemPreview',
	props: ['preview']
};
</script>