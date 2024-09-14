<template>
	<a-drawer title="Tools" placement="right" v-model:visible="openDrawer">
		<template v-for="tab in []" :key="tab.key">
			<div class="flex items-center cursor-pointer gap-4 p-2 rounded-lg hover:bg-gray-50">
				<Icon :name="tab.icon" :size="25" />
				<span>{{ tab.label }}</span>
			</div>
		</template>
	</a-drawer>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

defineEmits(['onClose'])

const { visible } = defineProps({
	visible: Boolean
});

const openDrawer = ref(false);

onMounted(() => {
	openDrawer.value = visible;
})

watch(openDrawer, (value) => {
	if (!value) {
		onClose()
	}
})

</script>