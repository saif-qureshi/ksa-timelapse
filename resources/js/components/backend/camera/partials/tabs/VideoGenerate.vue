<template>
  <div class="">
    <div class="space-x-2">
      <a-range-picker v-model:value="dates" />
      <a-button @click="getPhotos"> Search </a-button>
      <!-- <a-button
        type="primary"
        class="bg-blue-500"
        :disabled="photos.length <= 0"
      >
        Download
      </a-button> -->
      <a-button
        type="primary"
        class="bg-blue-500"
        :disabled="photos.length <= 0"
        :loading="loading"
        @click="generateTimelapse"
      >
        Generate
      </a-button>
    </div>
    <div class="my-3">
      <div class="mb-3">
        <p>{{ photos.length }} images found</p>
      </div>
      <a-carousel autoplay :dots="false" arrows>
        <div v-for="(photo, index) in photos" :key="`photo-${index}`">
          <img :src="photo.path" alt="" />
        </div>
      </a-carousel>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { message } from "ant-design-vue";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";

dayjs.extend(utc);

const { camera } = defineProps({
  camera: Object,
});

const loading = ref(false);
const photos = ref([]);
const dates = ref([
  dayjs().utcOffset(0).startOf("month"),
  dayjs().utcOffset(0).endOf("month"),
]);

const generateTimelapse = async () => {
  try {
    loading.value = true;
    await axios.post(`/camera/${camera.id}/video`, {
      start_date: dates.value[0]?.format("YYYY-MM-DD"),
      end_date: dates.value[1]?.format("YYYY-MM-DD"),
    });
    message.success("Video is being generate.");
  } catch (error) {
    if (error.response) {
      if (error.response.status === 422) {
        console.log(error.response.data.message);
        message.error(error.response.data.message);
      }
    } else {
      console.error(error);
      message.error("Something went wrong");
    }
  } finally {
    loading.value = false;
  }
};

const getPhotos = async () => {
  const { data } = await axios.post(`/camera/${camera.id}/photos`, {
    range: true,
    start_date: dates.value[0],
    end_date: dates.value[1],
  });
  photos.value = data;
  if (data.length > 0) {
    selectedPhoto.value = data[0];
  }
};

onMounted(() => {
  getPhotos();
});
</script>
