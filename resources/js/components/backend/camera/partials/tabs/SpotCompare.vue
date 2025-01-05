<template>
  <div>
    <vue-magnifier
      :src="mainImage"
      :zoomImgSrc="zoomImage"
      :mgWidth="300"
      :mgHeight="300"
    />
    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-2 md:col-span-1">
        <single-view 
          :camera="camera" 
          :show-main-image="false"
          :selected-image="primaryImage"
          :last-captured-at="lastCapturedAt"
          @onImageChange="(photo) => mainImage = photo"
        />
      </div>
      <div class="col-span-2 md:col-span-1">
        <single-view 
          :camera="camera" 
          :show-main-image="false"
          @onImageChange="(photo) => zoomImage = photo"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import SingleView from "./SingleView.vue";
import VueMagnifier from "@websitebeaver/vue-magnifier";
import "@websitebeaver/vue-magnifier/styles.css";

const { camera, primaryImage, lastCapturedAt } = defineProps({
  camera: Object,
  primaryImage: String,
  lastCapturedAt: String
});

const mainImage = ref(primaryImage ?? '');
const zoomImage = ref(null);

</script>
