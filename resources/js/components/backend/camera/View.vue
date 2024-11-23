<template>
  <div class="bg-white rounded-md">
    <div class="flex items-center justify-between p-2 bg-blue-500">
      <a-button type="primary" @click="goBack" class="bg-white text-blue-500">
        <Icon name="ArrowLeft" class="text-blue-500" size="16" />
      </a-button>
      <h1 class="text-white">{{ camera.name }}</h1>
      <a-button class="invisible">
        <Menu />
      </a-button>
      
    </div>
    <div class="flex relative">
      <div class="flex gap-4 flex-1">
        <component 
        class="flex-1 w-full"
        :is="getActiveTab().children" 
        :camera="camera" 
        v-bind="getActiveTab().props" 
        :user="user" 
      />
      <tools-drawer 
        v-model:open="visible" 
        :activeKey="activeKey"
        @onChange="handleToolSelection" 
      />
    </div>
    </div>
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

const tabs = ref([
{
		key: 'single-view',
    children: SingleView,
    props: {
      camera: camera,
      user: user,
      mode: 'single',
    }
	},
	{
		key: 'zoom-in',
    children: ZoomView,
    props: {
      camera: camera,
      user: user,
    }
	},
	{
		key: 'side-by-side',
    children: SideBySide,
    props: {
      camera: camera,
      user: user,
    }
	},
	{
		key: 'spot-zoom',
    children: SingleView,
    props: {
      camera: camera,
      user: user,
      mode: 'spot-zoom',
    }
	},
	{
		key: 'spot-compare',
    children: SpotCompare,
    props: {
      camera: camera,
      user: user,
    }
	},
	{
		key: 'compare',
    children: Compare,
    props: {
      camera: camera,
      user: user,
    }
	},
	{
		key: 'video',
    children: VideosList,
    props: {
      camera: camera,
      user: user,
    }
	},
	{
		key: 'custom-video',
    children: VideoGenerate,
    props: {
      camera: camera,
      user: user,
    }
	},
])

const visible = ref(false)
const activeKey = ref('single-view')

const goBack = () => {
  window.history.back();
};

const handleToolSelection = (key) => {
  activeKey.value = key
}

const getActiveTab = () => {
  return tabs.value.find(tab => tab.key === activeKey.value)
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
