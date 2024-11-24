<template>
  <div>
    <div class="px-4 w-full z-[888] bg-white" ref="zoomSliderContainer"><a-slider v-model:value="zoomLevel" :min="1"
        :max="5" :step="0.1" /></div>
    <div ref="panzoomContainer" style="width: 100%; height: 100%; overflow: hidden">
      <div ref="panzoom" style="width: 100%; height: 100%">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch, nextTick } from "vue";
import Panzoom from "@panzoom/panzoom";

const panzoomContainer = ref(null);
const zoomSliderContainer = ref(null);
const panzoom = ref(null);
const zoomLevel = ref(1);
let instance;

onMounted(async () => {
  await nextTick();

  instance = Panzoom(panzoom.value, {
    minScale: 1,
    maxScale: 4,
  });
  instance.pan(10, 10);

  onUnmounted(() => {
    panzoomContainer.value.removeEventListener("wheel", instance.zoomWithWheel);
    
    if (instance) {
      instance.destroy();
    }
  });

  watch(zoomLevel, (newValue) => {
    if (instance) {
      instance.zoom(newValue, { animate: true });
    }
  });
});

</script>
