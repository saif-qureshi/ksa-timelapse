<template>
  <div>
    <a-spin v-if="!leftImage || !rightImage"/>
    <VueCompareImage
      v-if="leftImage && rightImage"
      :leftImage="leftImage"
      :rightImage="rightImage"
    />
    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-2 md:col-span-1">
        <SingleView :camera="camera" @onImageChange="(photo) => leftImage = photo"/>
      </div>
      <div class="col-span-2 md:col-span-1">
        <SingleView :camera="camera" @onImageChange="(photo) => rightImage = photo"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import { VueCompareImage } from "vue3-compare-image";
import { ref } from 'vue';
import SingleView from "./SingleView.vue";

const { camera } = defineProps({
  camera: Object,
});

const leftImage = ref('');
const rightImage = ref('');
</script>
