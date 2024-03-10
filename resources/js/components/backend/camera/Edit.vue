<template>
  <div>
    <div class="grid grid-cols-12 mt-8">
      <div class="col-span-12 lg:col-span-8 sm:col-span-12">
        <h2 class="text-lg font-medium truncate mr-5">Edit Camera</h2>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
      <div class="intro-y col-span-12">
        <div class="w-full intro-y box p-5">
          <div class="flex flex-wrap mb-6">
            <a-form layout="vertical" class="w-full">
              <a-form-item label="Camera Index">
                <a-input
                  v-model:value="data.index"
                  value="0"
                  class="placeholder:text-sm shadow-sm rounded-md"
                />
                <span
                  v-if="hasError('camera_index')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("index") }}
                </span>
              </a-form-item>
              <a-form-item label="Camera Name">
                <a-input
                  v-model:value="data.name"
                  placeholder=""
                  class="placeholder:text-sm shadow-sm rounded-md"
                />
                <span
                  v-if="hasError('camera_name')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("name") }}
                </span>
              </a-form-item>
              <a-form-item label="Camera Description">
                <a-textarea
                  v-model:value="data.description"
                  class="placeholder:text-sm shadow-sm rounded-md"
                  placeholder="Enter description"
                  :rows="5"
                />
                <span
                  v-if="hasError('description')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("camera_description") }}
                </span>
              </a-form-item>
              <a-form-item label="Longitude">
                <a-input
                  v-model:value="data.longitude"
                  class="placeholder:text-sm shadow-sm rounded-md"
                  type="number"
                />
                <span
                  v-if="hasError('longitude')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("longitude") }}
                </span>
              </a-form-item>
              <a-form-item label="Latitude">
                <a-input
                  v-model:value="data.latitude"
                  class="placeholder:text-sm shadow-sm rounded-md"
                  placeholder=""
                  type="number"
                />
                <span
                  v-if="hasError('longitude')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("latitude") }}
                </span>
              </a-form-item>

              <div class="grid grid-cols-2 gap-5">
                <a-form-item label="Developer" class="col-span-1">
                  <a-select
                    :options="developers"
                    v-model:value="data.developer_id"
                    placeholder="Developer Access"
                    class="placeholder:text-sm shadow-sm rounded-md"
                    allow-clear
                    size="large"
                  />
                  <span
                    v-if="hasError('developers')"
                    class="block mt-1 text-red-500 text-xs font-semibold"
                  >
                    {{ hasError("developer_id") }}
                  </span>
                </a-form-item>
                <a-form-item label="Project" class="col-span-1">
                  <a-select
                    :options="projects"
                    v-model:value="data.project_id"
                    placeholder="Project Access"
                    class="placeholder:text-sm shadow-sm rounded-md"
                    allow-clear
                    size="large"
                  />
                  <span
                    v-if="hasError('project_id')"
                    class="block mt-1 text-red-500 text-xs font-semibold"
                  >
                    {{ hasError("projects") }}
                  </span>
                </a-form-item>
              </div>

              <a-form-item label="Is Active" class="w-1/2">
                <a-switch
                  v-model:checked="data.is_active"
                  :checked-value="1"
                  :unchecked-value="0"
                />
              </a-form-item>

              <div class="grid grid-cols-2 gap-5">
                <a-form-item
                  label="Video Tempate 1"
                  class="col-span-2 md:col-span-1"
                  :tooltip="videoTemplateToolTip"
                >
                  <a-input
                    v-model:value="data.video_template_1"
                    class="placeholder:text-sm shadow-sm rounded-md"
                  />
                  <span
                    v-if="hasError('video_template_1')"
                    class="block mt-1 text-red-500 text-xs font-semibold"
                  >
                    {{ hasError("video_template_1") }}
                  </span>
                </a-form-item>
                <a-form-item
                  label="Video Tempate 2"
                  class="col-span-2 md:col-span-1"
                  :tooltip="videoTemplateToolTip"
                >
                  <a-input
                    v-model:value="data.video_template_2"
                    class="placeholder:text-sm shadow-sm rounded-md"
                  />
                  <span
                    v-if="hasError('video_template_2')"
                    class="block mt-1 text-red-500 text-xs font-semibold"
                  >
                    {{ hasError("video_template_2") }}
                  </span>
                </a-form-item>
              </div>

              <a-space class="justify-end w-full">
                <a-button
                  type="primary"
                  :loading="loading"
                  :disabled="loading"
                  @click="onSubmit"
                  class="btn-primary bg-blue-500"
                >
                  Update
                </a-button>
              </a-space>
            </a-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import { message } from "ant-design-vue";
import axios from "axios";

const videoTemplateToolTip =
  "The field will be used to generate the customers video, the field format must be comma seperated without special charchters for example to generate 30 days video from 8am to 4pm the format is (title,numberOfDays,fromHour,toHour) the field will be -> Last 30 Days,30,8,16";

const { developers, camera } = defineProps({
  developers: Object,
  camera: Object,
});

const data = ref(camera);

const errors = ref({});
const projects = ref([]);
const loading = ref(false);

const hasError = (type, isCheck = false) => {
  if (type in errors.value && errors.value[type][0].length > 0) {
    if (isCheck) return true;
    return errors.value[type][0];
  }
  return false;
};

const onSubmit = async () => {
  try {
    loading.value = true;
    errors.value = {};
    await axios.put(`/camera/${camera.id}`, data.value);
    loading.value = false;
    message.success("Camera updated successfully");
    window.location.href = "/camera";
  } catch (error) {
    loading.value = false;
    if (error.response) {
      if (error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
    } else {
      message.error("Internet Disconnected");
    }
  }
};

const getProjectByDeveloper = async () => {
  try {
    const { data: serverProjects } = await axios.post(`/developer/project`, {
      developers: [data.value.developer_id],
    });
    projects.value = serverProjects;
  } catch (error) {
    console.log(error);
  }
};

onMounted(async () => {
  await getProjectByDeveloper();
});

watch(
  data.value.developer_id,
  async (newDeveloper) => await getProjectByDeveloper()
);
</script>
