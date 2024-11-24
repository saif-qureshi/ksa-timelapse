<template>
  <div>
    <div class="grid grid-cols-12 mt-8">
      <div class="col-span-12 lg:col-span-8 sm:col-span-12">
        <h2 class="text-lg font-medium truncate mr-5">Settings</h2>
      </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
      <div class="intro-y col-span-12">
        <div class="w-full intro-y box p-5">
          <a-form layout="vertical" class="w-full">
            <div class="grid grid-cols-2 flex-wrap gap-5 mb-6">
              <a-form-item
                label="Browse Login Image"
                class="col-span-2 md:col-span-1"
              >
                <FileUpload
                  ref="coverPhotoPond"
                  id="login_bg_image"
                  accept_file_types="image/jpeg, image/png"
                  label="Browse"
                  @removeFile="onRemoveFile($event, 'login_bg_image')"
                  max_file_size="1MB"
                  @process="setImage($event, 'login_bg_image')"
                  :my-files="data.login_bg_image"
                />
                <span
                  v-if="hasError('login_bg_image')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("login_bg_image") }}
                </span>
              </a-form-item>
              <a-form-item
                label="Browse Mobile Login Image"
                class="col-span-2 md:col-span-1"
              >
                <FileUpload
                  ref="coverPhotoPond"
                  id="mobile_login_bg_image"
                  accept_file_types="image/jpeg, image/png"
                  label="Browse"
                  @removeFile="onRemoveFile($event, 'mobile_login_bg_image')"
                  max_file_size="1MB"
                  @process="setImage($event, 'mobile_login_bg_image')"
                  :my-files="data.mobile_login_bg_image"
                />
                <span
                  v-if="hasError('mobile_login_bg_image')"
                  class="block mt-1 text-red-500 text-xs font-semibold"
                >
                  {{ hasError("mobile_login_bg_image") }}
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
                Save
              </a-button>
            </a-space>
          </a-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { message } from "ant-design-vue";
import FileUpload from "../FileUpload.vue";
import axios from "axios";

const { settings } = defineProps({
  settings: Object,
});

const data = reactive({ ...settings });
const errors = ref({});
const loading = ref(false);

const setImage = (img, key) => {
  data[key] = img;
};

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
    await axios.post("/settings", data);
    loading.value = false;
    message.success("Settings updated successfully");
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
</script>
