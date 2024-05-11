<template>
  <div>
    <SingleView :camera="camera" :mode="mode" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import SingleView from "./SingleView.vue";

const { camera, mode } = defineProps({
  camera: Object,
  mode: String,
});
</script>
