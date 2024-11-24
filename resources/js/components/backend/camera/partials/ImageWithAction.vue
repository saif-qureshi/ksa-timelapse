<template>
	<div class="relative">
		<!-- fullscreen button -->
		<a-button v-if="photo.path" class="absolute right-2 top-8 z-10 bg-black hover:bg-black/80 flex gap-x-2"
			type="primary" @click="toggleFullScreen">
			<icon name="Fullscreen" :size="20" color="#fff" />
			Full Screen
		</a-button>
		<!-- slot -->
		<slot></slot>

		<!-- navigation buttons -->
		<a-button v-if="photo.path"
			class="bg-black text-white shadow-md absolute top-1/2 -translate-y-1/2 left-4 h-10 w-10 flex justify-center items-center rounded-full p-0 transition-opacity hover:bg-black/80"
			:disabled="!canGoPrev" @click="handlePrev">
			<icon name="ArrowLeft" size="16" />
		</a-button>
		<a-button v-if="photo.path"
			class="bg-black text-white shadow-md absolute top-1/2 -translate-y-1/2 right-4 h-10 w-10 flex justify-center items-center rounded-full p-0 transition-opacity hover:bg-black/80"
			:disabled="!canGoNext" @click="handleNext">
			<icon name="ArrowRight" size="16" />
		</a-button>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import Icon from '../../..//Icon.vue';

const { photo, canGoPrev, canGoNext, imageRef } = defineProps({
	photo: {
		type: Object,
		required: true
	},
	canGoPrev: {
		type: Boolean,
		default: false
	},
	canGoNext: {
		type: Boolean,
		default: false
	}
});

const emit = defineEmits(['prev', 'next', 'fullscreen']);

const handlePrev = () => {
	emit('prev');
};

const handleNext = () => {
	emit('next');
};

const toggleFullScreen = () => {
	emit('fullscreen');
}
</script>