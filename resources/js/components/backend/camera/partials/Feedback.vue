<template>
  <div class="bg-white p-5 rounded-md mt-5">
    <div class="border-b flex gap-2 mb-5">
      <Icon name="MessageCircleMore" :size="30" />
      <h1 class="text-2xl">Post Your Feedback</h1>
    </div>
    <a-form
      ref="formRef"
      :rules="rules"
      :model="formState"
      @finish="submitFeebackForm"
      :disabled="loading"
    >
      <a-form-item name="message">
        <a-textarea
          v-model:value="formState.message"
          placeholder="Feedback goes here"
          :rows="5"
        ></a-textarea>
      </a-form-item>
      <a-form-item class="ml-auto text-right">
        <a-button html-type="submit" :loading="loading">Post</a-button>
      </a-form-item>
    </a-form>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import axios from "axios";
import Icon from "../../../Icon.vue";
import { message } from "ant-design-vue";

const { selectedPhoto } = defineProps({
  selectedPhoto: Object,
});

const formRef = ref();
const loading = ref(false);

const formState = reactive({
  message: "",
});

const rules = {
  message: [
    {
      required: true,
      message: "Please enter feedback message",
      trigger: "change",
    },
  ],
};

const submitFeebackForm = async (values) => {
  try {
    loading.value = true;
    await axios.post("/comments", {
      ...values,
      photo_id: selectedPhoto.id,
    });
    formRef.value.resetFields();
    message.success("Feedback posted successfully");
  } catch (error) {
    console.error(error);
    message.error("Something went wrong");
  } finally {
    loading.value = false;
  }
};
</script>
