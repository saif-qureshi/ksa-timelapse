<template>
	<a-drawer title="Tools" placement="right" v-model:open="openDrawer">
		<template v-for="tab in tabs" :key="tab.key">
			<div :class="['flex items-center cursor-pointer gap-4 p-3 rounded-lg hover:bg-gray-50 mb-2', { 'bg-blue-500 text-white hover:bg-blue-500 ': activeKey === tab.key }]"
				@click="emit('onChange', tab.key)">
				<Icon :name="tab.icon" :size="20" />
				<span>{{ tab.label }}</span>
			</div>
		</template>
	</a-drawer>
</template>

<script setup>
import { ref, watch } from 'vue';
import Icon from '../../../Icon.vue';

const emit = defineEmits(['update:visible', 'onChange']);

const { visible, activeKey } = defineProps({
	visible: Boolean,
	activeKey: String
});

const openDrawer = ref(false);

watch(() => visible, (newValue) => {
	openDrawer.value = newValue;
});

watch(openDrawer, (value) => {
	if (!value) {
		emit('update:visible', false);
	}
});

const tabs = [
	{
		key: 'single-view',
		icon: "Image",
		label: "Single View",
	},
	{
		key: 'zoom-in',
		icon: "ZoomIn",
		label: "Zoom",
	},
	{
		key: 'side-by-side',
		icon: "Columns2",
		label: "Side By Side",
	},
	{
		key: 'spot-zoom',
		icon: "Search",
		label: "Spot Zoom",
	},
	{
		key: 'spot-compare',
		icon: "Search",
		label: "Spot Compare",
	},
	{
		key: 'compare',
		icon: "GitCompare",
		label: "Compare",
	},
	{
		key: 'video',
		icon: "Film",
		label: "Video"
	},
	{
		key: 'custom-video',
		icon: "SearchCheck",
		label: "Custom Video",
	},
];

</script>