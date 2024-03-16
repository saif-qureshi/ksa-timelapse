<template>
  <div class="">
    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-2 md:col-span-1">
        <SingleView :camera="camera" :mode="mode"/>
      </div>
      <div class="col-span-2 md:col-span-1">
        <SingleView :camera="camera" :mode="mode"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import SingleView from "./SingleView.vue";
const { camera, mode } = defineProps({
  camera: Object,
  mode: String
});
</script>
