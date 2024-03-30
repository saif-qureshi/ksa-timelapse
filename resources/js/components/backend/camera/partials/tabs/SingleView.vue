<template>
  <div>
    <div class="image-wrapper">
      <img :src="selectedPhoto.path" v-if="mode === 'single'" />
      <div v-if="mode === 'spot-zoom'">
        <VueMagnifier
          :src="selectedPhoto.path"
          :mgWidth="300"
          :mgHeight="300"
        />
      </div>
    </div>
    <div class="mt-5">
      <div>
        <label class="block mb-3">Photos Date: </label>
        <a-date-picker v-model:value="selectedDate" class="w-56" />
        <ImageSlider
          :photos="photos"
          :selected="selectedPhoto.id"
          @onSelect="handleImageSelect"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import dayjs from "dayjs";
import ImageSlider from "../ImageSlider.vue";
import { onMounted, ref } from "vue";
import VueMagnifier from "@websitebeaver/vue-magnifier";
import "@websitebeaver/vue-magnifier/styles.css";

const { camera, mode } = defineProps({
  camera: Object,
  mode: {
    type: String,
    default: null,
  },
});

const photos = ref([]);
const selectedDate = ref(dayjs());
const selectedPhoto = ref({});

const getPhotos = async () => {
  const { data } = await axios.get(`/camera/${camera.id}/photos`, {
    params: {
      date: selectedDate.value.format("YYYY-MM-DD"),
    },
  });
  if (data.length > 0) {
    photos.value = data;
    selectedPhoto.value = data[0];
  }
};

const emit = defineEmits(["onImageChange"]);

const handleImageSelect = (photo) => {
  selectedPhoto.value = photo;
  emit("onImageChange", photo.path);
};

const init = async () => {
  await getPhotos();
  emit("onImageChange", selectedPhoto.value.path);
};

onMounted(() => {
  init();
});
</script>
