<template>
  <div class="mt-5">
    <div class="w-full">
      <ul class="grid gap-2 mb-0 overflow-x-auto grid-flow-col">
        <li
          v-for="photo in photos"
          class="relative cursor-pointer w-56"
          :class="{ 'border-4 border-blue-500': selected === photo.id }"
          :key="photo.image"
          @click="() => selectPhoto(photo)"
        >
          <img :src="photo.path" :alt="photo.image" class="h-auto w-full" />
          <div
            class="absolute flex justify-end items-start top-[50%] left-[50%] bg-black/30 w-full h-full translate-x-[-50%] translate-y-[-50%]"
          >
            <span class="bg-white px-2.5 rounded-es-md">
              {{ dayjs(photo.created_at).format("HH:mm") }}
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
