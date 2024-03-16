<template>
  <div class="">
    <VueMagnifier
      :src="mainImage"
      :zoomImgSrc="zoomImage"
      :mgWidth="300"
      :mgHeight="300"
    />
    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-2 md:col-span-1">
        <SingleView :camera="camera" @onImageChange="(photo) => mainImage = photo"/>
      </div>
      <div class="col-span-2 md:col-span-1">
        <SingleView :camera="camera" @onImageChange="(photo) => zoomImage = photo"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import SingleView from "./SingleView.vue";
import VueMagnifier from "@websitebeaver/vue-magnifier";
import "@websitebeaver/vue-magnifier/styles.css";

const { camera } = defineProps({
  camera: Object,
});

const mainImage = ref(null);
const zoomImage = ref(null);

</script>
