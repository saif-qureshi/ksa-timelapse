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
          <component :is="tab.children" :camera="camera" />
        </a-tab-pane>
      </a-tabs>
    </div>
    <Feedback />
  </div>
</template>

<script setup>
import { ref } from "vue";
import Icon from "../../Icon.vue";
import SingleView from "./partials/tabs/SingleView.vue";
import ZoomView from "./partials/tabs/ZoomView.vue";
import Feedback from "./partials/Feedback.vue";
import SideBySide from "./partials/tabs/SideBySide.vue";

const { camera } = defineProps({
  camera: Object,
});

const tabs = [
  {
    key: 1,
    icon: "Image",
    label: "Single View",
    children: SingleView,
  },
  {
    key: 4,
    icon: "Columns2",
    label: "Side By Side",
    children: SideBySide,
  },
  {
    key: 5,
    icon: "Search",
    label: "Spot Compare",
    children: ZoomView,
  },
  {
    key: 6,
    icon: "GitCompare",
    label: "Compare",
    children: ZoomView,
  },
  {
    key: 7,
    icon: "Film",
    label: "Video",
    children: ZoomView,
  },
  {
    key: 8,
    icon: "Printer",
    label: "Print",
    children: ZoomView,
  },
  {
    key: 9,
    icon: "SearchCheck",
    label: "Search",
    children: ZoomView,
  },
];

let activeKey = ref(1);
</script>
