<template>
  <div class="bg-white rounded-md">
    <div class="flex items-center justify-between p-2">
      <a-button type="primary" @click="goBack">Go Back</a-button>
      <h1>Camera Name</h1>
      <a-button class="h-10 w-10 flex justify-center items-center p-0" @click="toggleDrawer">
        <Menu />
      </a-button>
      
    </div>
    <div class="flex gap-4"></div>
    <!-- <component :is="tab.children" :camera="camera" v-bind="tab.props" :user="user" /> -->
    <tools-drawer 
      v-model:open="visible" 
      :activeKey="activeKey"
      @onChange="handleToolSelection" 
    />
  </div>
</template>

<script setup>
import { nextTick, onMounted, onUnmounted, ref } from "vue";
import SingleView from "./partials/tabs/SingleView.vue";
import SideBySide from "./partials/tabs/SideBySide.vue";
import SpotCompare from "./partials/tabs/SpotCompare.vue";
import ZoomView from "./partials/tabs/ZoomView.vue";
import Compare from "./partials/tabs/Compare.vue";
import VideosList from "./partials/tabs/VideosList.vue";
import VideoGenerate from "./partials/tabs/VideoGenerate.vue";

import { Menu } from 'lucide-vue-next';
import ToolsDrawer from "./partials/ToolsDrawer.vue";

const { camera, user } = defineProps({
  camera: Object,
  user: Object,
});

onMounted(async () => {
  await nextTick()
  const parent = document.getElementById('backend-app');
  const element = document.querySelector('.ant-tabs-nav');
  const scroller = document.getElementById('zoomScroller');

  const handleScroll = () => {
    if (window.scrollY > 100) {
      element.style.width = `${parent.offsetWidth}px`;;
      element.classList.add('fixed-top');
      if (scroller) {
        scroller.style.position = 'fixed';
        scroller.style.top = '10px';
      }
    } else {
      // remove widht
      element.style.width = '';
      element.classList.remove('fixed-top');
      if (scroller) {
        scroller.style.position = 'relative';
        scroller.style.top = '0';
      }
    }
  };

  window.addEventListener('scroll', handleScroll);

  onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
  });
});

const visible = ref(false)
const activeKey = ref('single-view')

const toggleDrawer = () => {
  visible.value = !visible.value
}
const goBack = () => {
  window.history.back();
};

const handleToolSelection = (key) => {
  activeKey.value = key
}

</script>

<style>
#backend-app .ant-tabs-nav {
  z-index: 999;
  background: #fff;
  padding: 10px;
  margin-bottom: 0px;
  flex-direction: row-reverse;
  justify-content: space-between;
}

#backend-app .ant-tabs-nav .ant-tabs-nav-wrap {
  flex: none;
}

.fixed-top {
  position: fixed !important;
  top: 0;
}

.ant-drawer-body {
  padding-left: 15px;
}
</style>
