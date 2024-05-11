<template>
  <div>
    <a-slider v-model:value="zoomLevel" :min="1" :max="5" :step="0.1" />
    <div
      ref="panzoomContainer"
      style="width: 100%; height: 100%; overflow: hidden"
    >
      <div ref="panzoom" style="width: 100%; height: 100%">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from "vue";
import Panzoom from "@panzoom/panzoom";

const panzoomContainer = ref(null);
const panzoom = ref(null);
let instance;
const zoomLevel = ref(1);

onMounted(() => {
  instance = Panzoom(panzoom.value);
  instance.pan(10, 10);
});

onUnmounted(() => {
  if (instance) {
    instance.destroy();
  }
});

watch(zoomLevel, (newValue) => {
  if (instance) {
    instance.zoom(newValue, { animate: true });
  }
});
</script>
