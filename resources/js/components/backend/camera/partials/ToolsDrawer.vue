<template>
	<div class="px-5 p-2 rounded-full shadow-md bg-white flex gap-2 overflow-x-auto">
		<template v-for="tab in tabs" :key="tab.key">
			<a-tooltip :title="tab.label" placement="top">
				<a-button
					:class="['flex items-center justify-center cursor-pointer gap-2 p-2 h-10 w-10  border-none shadow-none rounded-md transition-all duration-300', { 'bg-blue-500 text-white hover:bg-blue-700 ': activeKey === tab.key, 'hover:bg-gray-100': activeKey !== tab.key }]"
					@click="emit('onChange', tab.key)">
					<Icon :name="tab.icon" :size="20" />
				</a-button>
			</a-tooltip>
		</template>
	</div>
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
		key: 'spot-zoom',
		icon: "ScanSearch",
		label: "Spot Zoom",
	},
	{
		key: 'side-by-side',
		icon: "Columns2",
		label: "Side By Side",
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