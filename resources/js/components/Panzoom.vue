<template>
  <div>
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
const panzoom = ref(null);
let instance;

onMounted(async () => {
  await nextTick();

  instance = Panzoom(panzoom.value, {
    minScale: 1,
    maxScale: 4,
  });
  instance.pan(10, 10);

  panzoomContainer.value.addEventListener("wheel", instance.zoomWithWheel);

  onUnmounted(() => {
    panzoomContainer.value.removeEventListener("wheel", instance.zoomWithWheel);
    if (instance) {
      instance.destroy();
    }
  });
});

</script>
