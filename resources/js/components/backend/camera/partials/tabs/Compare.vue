<template>
  <div>
    <a-spin v-if="!leftImage || !rightImage"/>
    <vue-compare-image
      v-if="leftImage && rightImage"
      :leftImage="leftImage"
      :rightImage="rightImage"
    />
    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-2 md:col-span-1">
        <single-view 
          :camera="camera" 
          :show-main-image="false"
          :selected-image="primaryImage"
          :last-captured-at="lastCapturedAt"
          @onImageChange="(photo) => leftImage = photo"
        />
      </div>
      <div class="col-span-2 md:col-span-1">
        <single-view 
          :camera="camera" 
          :show-main-image="false"
          @onImageChange="(photo) => rightImage = photo"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { VueCompareImage } from "vue3-compare-image";
import { ref } from 'vue';
import SingleView from "./SingleView.vue";

const { camera, primaryImage, lastCapturedAt } = defineProps({
  camera: Object,
  primaryImage: String,
  lastCapturedAt: String
});

const leftImage = ref(primaryImage ?? '');
const rightImage = ref('');
</script>
