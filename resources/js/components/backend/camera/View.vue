<template>
  <div>
    <div class="mt-12 bg-white p-5 rounded-md">
      <a-tabs v-model:activeKey="activeKey" type="card" tabPosition="top">
        <a-tab-pane v-for="tab in tabs" :key="tab.key">
          <template #tab>
            <div class="flex items-center gap-1">
              <Icon :name="tab.icon" :size="20" />
              <span>{{ tab.label }}</span>
            </div>
          </template>
          <component :is="tab.children" :camera="camera" v-bind="tab.props" />
        </a-tab-pane>
      </a-tabs>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Icon from "../../Icon.vue";
import SingleView from "./partials/tabs/SingleView.vue";
import SideBySide from "./partials/tabs/SideBySide.vue";
import SpotCompare from "./partials/tabs/SpotCompare.vue";
import ZoomView from "./partials/tabs/ZoomView.vue";
import Compare from "./partials/tabs/Compare.vue";
import VideosList from "./partials/tabs/VideosList.vue";
import VideoGenerate from "./partials/tabs/VideoGenerate.vue";

const { camera } = defineProps({
  camera: Object,
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
    label: "Search",
    children: VideoGenerate,
    props: {},
  },
];

let activeKey = ref(1);
</script>
