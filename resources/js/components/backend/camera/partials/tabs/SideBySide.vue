<template>
  <div class="grid grid-cols-2 gap-1">
    <div class="col-span-2 md:col-span-1">
      <single-view 
        :camera="camera" 
        :mode="mode" 
        :selected-image="primaryImage" 
        :last-captured-at="lastCapturedAt"
      />
    </div>
    <div class="col-span-2 md:col-span-1">
      <single-view 
        :camera="camera" 
        :mode="mode"
      />
    </div>
  </div>
</template>

<script setup>
import SingleView from "./SingleView.vue";
const { camera, mode, primaryImage, lastCapturedAt } = defineProps({
  camera: Object,
  mode: String,
  primaryImage: String,
  lastCapturedAt: String
});
</script>
