<template>
  <div class="bg-white rounded-md">
    <div class="flex p-2">
      <a-button type="primary" @click="goBack">Go Back</a-button>
      <div class="ml-auto">
        <a-button class="h-10 w-10 flex justify-center items-center p-0" @click="toggleDrawer">
          <Menu />
        </a-button>
      </div>
    </div>
    <!-- <component :is="tab.children" :camera="camera" v-bind="tab.props" :user="user" /> -->
    <ToolsDrawer :visible="visible" @onClose="toggleDrawer" />
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

const toggleDrawer = () => {
  visible.value = !visible.value
}
const goBack = () => {
  window.history.back();
};
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
