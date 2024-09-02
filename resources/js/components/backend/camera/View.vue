<template>
  <div class="bg-white rounded-md">
    <a-tabs v-model:activeKey="activeKey" type="card" tabPosition="top">
      <a-tab-pane v-for="tab in tabs" :key="tab.key">
        <template #tab>
          <div class="flex items-center gap-1">
            <Icon :name="tab.icon" :size="20" />
            <span>{{ tab.label }}</span>
          </div>
        </template>
        <component :is="tab.children" :camera="camera" v-bind="tab.props" :user="user" />
      </a-tab-pane>
      <template #tabBarExtraContent>
        <a-button type="primary" @click="goBack">Go Back</a-button>
      </template>
    </a-tabs>
  </div>
</template>

<script setup>
import { nextTick, onMounted, onUnmounted, ref } from "vue";
import Icon from "../../Icon.vue";
import SingleView from "./partials/tabs/SingleView.vue";
import SideBySide from "./partials/tabs/SideBySide.vue";
import SpotCompare from "./partials/tabs/SpotCompare.vue";
import ZoomView from "./partials/tabs/ZoomView.vue";
import Compare from "./partials/tabs/Compare.vue";
import VideosList from "./partials/tabs/VideosList.vue";
import VideoGenerate from "./partials/tabs/VideoGenerate.vue";

const { camera, user } = defineProps({
  camera: Object,
  user: Object,
});

onMounted(async () => {
  await nextTick()
  const parent = document.getElementById('backend-app');
  const element = document.querySelector('.ant-tabs-nav');


  const handleScroll = () => {
    if (window.scrollY > 100) {
      element.style.width = `${parent.offsetWidth}px`;;
      element.classList.add('fixed-top');
    } else {
      // remove widht
      element.style.width = '';
      element.classList.remove('fixed-top');
    }
  };

  window.addEventListener('scroll', handleScroll);

  onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
  });
});

const tabs = [
  {
    key: 1,
    icon: "Image",
    label: "Single View",
    children: SingleView,
    props: {
      mode: "single",
    },
  },
  {
    key: 2,
    icon: "ZoomIn",
    label: "Zoom",
    children: ZoomView,
    props: {
      mode: "zoom",
    },
  },
  {
    key: 3,
    icon: "Columns2",
    label: "Side By Side",
    children: SideBySide,
    props: {
      mode: "single",
    },
  },
  {
    key: 4,
    icon: "Search",
    label: "Spot Zoom",
    children: SingleView,
    props: {
      mode: "spot-zoom",
    },
  },
  {
    key: 5,
    icon: "Search",
    label: "Spot Compare",
    children: SpotCompare,
    props: {
      mode: "spot-zoom",
    },
  },
  {
    key: 6,
    icon: "GitCompare",
    label: "Compare",
    children: Compare,
    props: {},
  },
  {
    key: 7,
    icon: "Film",
    label: "Video",
    children: VideosList,
    props: {},
  },
  {
    key: 8,
    icon: "SearchCheck",
    label: "Custom Video",
    children: VideoGenerate,
    props: {},
  },
];

let activeKey = ref(1);

const goBack = () => {
  window.history.back();
};
</script>

<style>
#backend-app .ant-tabs-nav {
  /* position: sticky; */
  /* top: -20px; */
  z-index: 999;
  background: #fff;
  padding: 10px;
  margin-bottom: 0px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.fixed-top {
  position: fixed !important;
  top: 0;
}
</style>
