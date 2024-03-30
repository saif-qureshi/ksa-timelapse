<template>
    <div class="bg-white p-5 rounded-md mt-5">
      <div class="border-b flex gap-2 mb-5">
        <Icon name="MessageCircleMore" :size="30" />
        <h1 class="text-2xl">Post Your Feedback</h1>
      </div>
      <a-form @finish="postFeedback">
        <a-form-item>
          <a-textarea v-model="feedback" placeholder="Feedback goes here" :rows="5"></a-textarea>
        </a-form-item>
        <a-form-item class="ml-auto text-right">
          <a-button html-type="submit">Post</a-button>
        </a-form-item>
      </a-form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import Icon from "../../../Icon.vue";
  
  let feedback = ref('');
  
  const postFeedback = async () => {
    try {
      await axios.post('/comments', { feedback: feedback.value, camera_id: $props.cameraId });
      feedback.value = '';
    } catch (error) {
      console.error(error);
    }
  };
  </script>
  