<template>
  <div class="mt-5">
    <div class="w-full overflow-x-auto">
      <a-empty v-if="photos.length <= 0" description="No image available"/>
      <ul class="flex gap-2 mb-0" v-if="photos.length > 0">
        <li
          v-for="photo in photos"
          class="relative cursor-pointer"
          :class="{ 'border-4 border-blue-500': selected === photo.id }"
          :key="photo.image"
          :style="{flex: '0 0 14rem'}"
          @click="() => selectPhoto(photo)"
        >
          <img :src="photo.path" :alt="photo.image" class="h-full w-full object-contain" />
          <div
            class="absolute flex justify-end items-start top-[50%] left-[50%] bg-black/30 w-full h-full translate-x-[-50%] translate-y-[-50%]"
          >
            <span class="bg-white px-2.5 rounded-es-md">
              {{ photo.captured_at}}
            </span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import dayjs from "dayjs";

const { photos, selected } = defineProps({
  selected: Number,
  photos: Object,
});

const emit = defineEmits(["onSelect"]);

const selectPhoto = (photo) => {
  emit("onSelect", photo);
};
</script>
