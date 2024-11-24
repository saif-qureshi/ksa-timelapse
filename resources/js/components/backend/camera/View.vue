<template>
  <div class="bg-white rounded-md">
    <div class="flex items-center flex-wrap gap-3 justify-between p-2 bg-blue-500">
      <a-button type="primary" @click="window.history.back()" class="bg-white text-blue-500">
        <icon name="ArrowLeft" class="text-blue-500" size="20" />
      </a-button>
      <tools-drawer 
        :activeKey="activeKey"
        @onChange="key => activeKey = key" 
      />
      <h1 class="text-white">{{ camera.name }}</h1>
    </div>
    <div class="flex relative">
      <keep-alive>
        <single-view
          v-if="['single-view','zoom-in','spot-zoom'].includes(activeKey)"
          :camera="camera" 
          :user="user" 
          :mode="activeKey" 
          :showMainImage="true"
          @on-image-change="handleImageChange"
        />
      </keep-alive>
      <side-by-side
        v-show="activeKey === 'side-by-side'"
        :camera="camera" 
        :user="user" 
        :primary-image="primaryImage"
      />
      <spot-compare
        v-show="activeKey === 'spot-compare'"
        :camera="camera" 
        :user="user" 
        :primary-image="primaryImage"
      />
      <compare
        v-show="activeKey === 'compare'"
        :camera="camera" 
        :user="user" 
        :primary-image="primaryImage"
      />  
      <keep-alive>
        <videos-list
          v-if="activeKey === 'video'"
        :camera="camera" 
          :user="user" 
        />
      </keep-alive>
      <keep-alive>
        <video-generate
          v-if="activeKey === 'custom-video'"
          :camera="camera" 
          :user="user" 
        />
      </keep-alive>
    </div>
  </div>
</template>

<script setup>
import { defineAsyncComponent, ref } from "vue";
import Icon from "../../Icon.vue";
import ToolsDrawer from "./partials/ToolsDrawer.vue";

const SingleView = defineAsyncComponent(() => import('./partials/tabs/SingleView.vue'));
const Compare = defineAsyncComponent(() => import('./partials/tabs/Compare.vue'));
const SideBySide = defineAsyncComponent(() => import('./partials/tabs/SideBySide.vue'));
const SpotCompare = defineAsyncComponent(() => import('./partials/tabs/SpotCompare.vue'));
const VideosList = defineAsyncComponent(() => import('./partials/tabs/VideosList.vue'));
const VideoGenerate = defineAsyncComponent(() => import('./partials/tabs/VideoGenerate.vue'));

const { camera, user } = defineProps({
  camera: {
    type: Object,
    required: true
  },
  user: {
    type: Object,
    required: true
  }
});

const activeKey = ref('single-view');
const primaryImage = ref(null);

const handleImageChange = (image) => {
  primaryImage.value = image;
}

</script>
