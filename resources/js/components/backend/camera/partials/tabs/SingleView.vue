<template>
  <div>
    <div class="image-wrapper">
      <div class="" v-if="mode === 'single'">
        <a-button
          v-if="selectedPhoto.path"
          class="absolute right-2 top-2 bg-black hover:bg-black/80! flex gap-x-2"
          type="primary"
          @click="toggleFullScreen"
        >
          <Icon name="Fullscreen" :size="20" color="#fff" />
          Full Screen
        </a-button>
        <div class="" ref="imageRef">
          <!-- <a-button
            v-if="showFullScreen"
            class="absolute top-[50%] translate-y-[-50%] bg-black left-2"
          >
            <Icon name="ChevronLeft" :size="20" color="#fff" />
          </a-button> -->
          <img :src="selectedPhoto.path" />
          <!-- <a-button
            v-if="showFullScreen"
            class="absolute top-[50%] translate-y-[-50%] bg-black right-2"
          >
            <Icon name="ChevronRight" :size="20" color="#fff" />
          </a-button> -->
        </div>

        <div v-if="showFullScreen" class="full-screen-overlay">
          <div class="full-screen-container">
            <img
              :src="selectedPhoto.path"
              alt="Full Screen Image"
              @click="showFullScreen = !showFullScreen"
            />
          </div>
        </div>
      </div>
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
    <Feedback :selectedPhoto="selectedPhoto" />
  </div>
</template>

<script setup>
import axios from "axios";
import dayjs from "dayjs";
import ImageSlider from "../ImageSlider.vue";
import { onMounted, ref, watch } from "vue";
import VueMagnifier from "@websitebeaver/vue-magnifier";
import "@websitebeaver/vue-magnifier/styles.css";
import Icon from "../../../../Icon.vue";
import Feedback from "../Feedback.vue";

const { camera, mode } = defineProps({
  camera: Object,
  mode: {
    type: String,
    default: null,
  },
});

const imageRef = ref(null);
const photos = ref([]);
const selectedDate = ref(dayjs());
const selectedPhoto = ref({});
const showFullScreen = ref(false);

const getPhotos = async () => {
  const { data } = await axios.post(`/camera/${camera.id}/photos`, {
    date: selectedDate.value.format("YYYY-MM-DD"),
  });
  photos.value = data;
  if (data.length > 0) {
    selectedPhoto.value = data[0];
  }
};

const toggleFullScreen = () => {
  showFullScreen.value = !showFullScreen.value;
  const imageElement = imageRef.value;

  if (document.fullscreenElement) {
    document.exitFullscreen();
  } else {
    if (imageElement.requestFullscreen) {
      imageElement.requestFullscreen();
    } else if (imageElement.webkitRequestFullscreen) {
      imageElement.webkitRequestFullscreen();
    } else if (imageElement.msRequestFullscreen) {
      imageElement.msRequestFullscreen();
    }
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

watch(selectedDate, (newValue, oldValue) => {
  getPhotos();
});
</script>

<style>
.full-screen-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.full-screen-container {
  max-width: 100%;
  max-height: 100%;
  overflow: hidden;
}

.full-screen-container img {
  max-width: 100%;
  max-height: 100%;
  cursor: pointer;
}
</style>
