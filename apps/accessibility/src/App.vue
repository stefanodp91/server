<template>
	<div id="accessibility">
		<div id="themes" class="section">
			<h2>{{t('accessibility', 'Themes')}}</h2>
			<div class="themes-list">
				<preview v-for="preview in themes" :key="preview.id"></preview>
			</div>
		</div>
		<div id="themes" class="section">
			<h2>{{t('accessibility', 'Fonts')}}</h2>
			<div class="fonts-list">
				<preview v-for="preview in fonts" :key="preview.id"></preview>
			</div>
		</div>
	</div>
</template>

<script>
import preview from './components/itemPreview';

export default {
	name: 'app',
	components: { preview },
	beforeMount() {
		// importing server data into the app
		const serverDataElmt = document.getElementById('serverData');
		if (serverDataElmt !== null) {
			this.serverData = JSON.parse(
				document.getElementById('serverData').dataset.server
			);
		}
	},
	data() {
		return {
			serverData: []
		};
	},
	computed: {
		themes() {
			return this.serverData.themes;
		},
		fonts() {
			return this.serverData.fonts;
		}
	}
};
</script>
