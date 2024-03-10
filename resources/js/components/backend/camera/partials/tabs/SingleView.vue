<template>
  <div>
    <a-image :src="selectedPhoto.path"  fallback="https://placehold.co/1024x1024?text=No+Image+Found"/>
    <div class="mt-5">
      <div>
        <label class="block mb-3">Photos Date: </label>
        <a-date-picker v-model:value="selectedDate" class="w-56" />
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import dayjs from "dayjs";
import { computed, onMounted, ref } from "vue";

const { camera } = defineProps({
  camera: Object,
});

const photos = ref([]);
const selectedDate = ref(dayjs('03-03-2024'));
const selectedPhoto = ref({});

const getPhotos = async () => {
  const { data } = await axios.get(`/camera/${camera.id}/photos`, {
    params: {
      date: selectedDate.value.format("YYYY-MM-DD"),
    },
  });
	if(data.length > 0 ){
		photos.value = data;
		selectedPhoto.value = data[0]
		console.log(selectedPhoto.value);
	}
};

onMounted(() => {
  getPhotos();
});
</script>
