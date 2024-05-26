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
          <a-empty
            v-if="!selectedPhoto.path"
            description="No image available"
          />
          <img v-else :src="selectedPhoto.path" class="w-full" />
        </div>

        <div v-if="showFullScreen" class="full-screen-overlay">
          <div class="full-screen-container">
            <a-empty
              v-if="!selectedPhoto.path"
              description="No image available"
            />
            <img
              v-else
              :src="selectedPhoto.path"
              alt="Full Screen Image"
              @click="showFullScreen = !showFullScreen"
            />
          </div>
        </div>
      </div>
      <div v-if="mode === 'spot-zoom'">
        <a-empty v-if="!selectedPhoto.path" description="No image available" />
        <VueMagnifier
          v-else
          :src="selectedPhoto.path"
          :mgWidth="300"
          :mgHeight="300"
        />
      </div>
      <div v-if="mode === 'zoom'">
        <a-empty v-if="!selectedPhoto.path" description="No image available" />
        <Panzoom v-else>
          <img :src="selectedPhoto.path" alt="Image" class="w-full" />
        </Panzoom>
      </div>
    </div>
    <div class="mt-5">
      <div class="flex justify-between items-center">
        <div>
          <label class="block mb-3">Photos Date: </label>
          <a-date-picker
            v-model:value="selectedDate"
            class="w-56"
            :disabled-date="getDisableDates"
          />
        </div>
        <a-popconfirm
          v-if="
            ['super_admin', 'admin', 'project_admin'].includes(user.role) &&
            mode === 'single' &&
            selectedPhoto.path
          "
          title="Are you sure to delete this photo?"
          @confirm="handleImageDelete"
        >
          <a-button
            class="bg-red-500 hover:bg-red-600 text-white"
            type="danger"
          >
            Delete This Photo
          </a-button>
        </a-popconfirm>
      </div>
      <ImageSlider
        :photos="photos"
        :selected="selectedPhoto.id"
        @onSelect="handleImageSelect"
      />
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
import Panzoom from "../../../../Panzoom.vue";

const { camera, mode, user } = defineProps({
  camera: Object,
  user: Object,
  mode: {
    type: String,
    default: null,
  },
});

const imageRef = ref(null);
const photos = ref([]);
const disabledDates = ref([]);
const selectedDate = ref(dayjs());
const selectedPhoto = ref({});
const showFullScreen = ref(false);

const getPhotos = async () => {
  const {
    data: { photos: dbPhotos, dates },
  } = await axios.post(`/camera/${camera.id}/photos`, {
    date: selectedDate.value.format("YYYY-MM-DD"),
  });
  photos.value = dbPhotos;
  disabledDates.value = dates;
  if (dbPhotos.length > 0) {
    selectedPhoto.value = dbPhotos[0];
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

const handleImageDelete = async () => {
  await axios.delete(`/camera/${camera.id}/photos/${selectedPhoto.value.id}`);
  await getPhotos();
};

const getDisableDates = (current) => {
  return disabledDates.value.find(
    (date) => date === dayjs(current).format("YYYY-MM-DD")
  );
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

watch(selectedDate, () => {
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
