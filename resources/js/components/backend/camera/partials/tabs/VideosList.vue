<template>
  <div class="space-x-3">
    <a-range-picker v-model:value="dates" />
    <a-button @click="getVideos"> Search </a-button>

    <a-table
      :dataSource="videos"
      :columns="columns"
      class="mt-5"
      :loading="loading"
    >
      <template #bodyCell="{ column, record }">
        <template v-if="column.key === 'status'">
          <a-tag class="capitalize" color="green">{{ record.status }}</a-tag>
        </template>
        <template v-if="column.key === 'action'">
          <a-space>
            <a-tooltip title="Download Video">
              <a-button
                class="w-8 h-8 flex justify-center items-center p-0"
                @click="() => downloadVideo(record)"
              >
                <Icon name="Download" size="16" />
              </a-button>
            </a-tooltip>
            <a-tooltip title="Play video">
              <a-button
                class="w-8 h-8 flex justify-center items-center p-0"
                @click="() => playVideo(record)"
              >
                <Icon name="Play" size="16" />
              </a-button>
            </a-tooltip>
            <a-tooltip title="Delete video">
              <a-popconfirm title="Delete Video" description="Are you sure you want to delete ?" @confirm="() => deleteVideo(record.id)">
                <a-button class="w-8 h-8 flex justify-center items-center p-0">
                  <Icon name="Trash" size="16" />
                </a-button>
              </a-popconfirm>
            </a-tooltip>
          </a-space>
        </template>
      </template>
    </a-table>

    <a-modal
      v-model:open="playVideoModal"
      title="Play Timelapse Video"
      @cancel="() => (playVideoModal.value = false)"
      :footer="false"
      centered
    >
      <video
        :src="selectedVideoSrc"
        controls
        width="100%"
        height="500px"
      ></video>
    </a-modal>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Icon from "../../../../Icon.vue";
import dayjs from "dayjs";
import { message } from "ant-design-vue";

const { camera } = defineProps({
  camera: Object,
});

const playVideoModal = ref(false);
const selectedVideoSrc = ref(null);
const loading = ref(false);
const videos = ref([]);
const dates = ref([dayjs().startOf("month"), dayjs().endOf("month")]);

const columns = [
  {
    title: "Name",
    dataIndex: "name",
    key: "name",
  },
  {
    title: "Status",
    dataIndex: "status",
    key: "status",
  },
  {
    title: "Generated",
    dataIndex: "generated_at",
    key: "generated_at",
  },
  {
    title: "Action",
    key: "action",
  },
];

const getVideos = async () => {
  try {
    loading.value = true;
    const { data } = await axios.get(`/camera/${camera.id}/videos`, {
      params: {
        start_date: dates.value[0]?.format("YYYY-MM-DD"),
        end_date: dates.value[1]?.format("YYYY-MM-DD"),
      },
    });
    videos.value = data;
  } catch (error) {
    console.error(error);
    message.error("Something went wrong");
  } finally {
    loading.value = false;
  }
};

const deleteVideo = async (id) => {
  try {
    await axios.delete(`/camera/${camera.id}/videos/${id}`);
    getVideos();
  } catch (error) {
    console.error(error);
    message.error("Something went wrong");
  }
};

const downloadVideo = async (record) => {
  try {
    const response = await axios.get(record.path, {
      responseType: "blob",
    });
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", record.file.replace("video/", ""));
    document.body.appendChild(link);
    link.click();
    window.URL.revokeObjectURL(url);
  } catch (error) {
    console.error(error);
    message.error("Error while downloading video");
  }
};

const playVideo = (record) => {
  selectedVideoSrc.value = record.path;
  playVideoModal.value = true;
};

onMounted(() => {
  getVideos();
});
</script>
