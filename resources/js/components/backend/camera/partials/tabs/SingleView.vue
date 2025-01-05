<template>
  <div>
    <div class="image-wrapper">
      <div class="relative" v-if="showMainImage && mode === 'single-view'" ref="imageRef">
        <image-with-action :photo="selectedPhoto" :can-go-next="canGoNext" :can-go-prev="canGoPrev" @next="goNext"
          @prev="goPrev" @fullscreen="toggleFullScreen">
          <a-empty v-if="!selectedPhoto.path" description="No image available" />
          <img v-else :src="selectedPhoto.path" :alt="selectedPhoto.title || 'Image'" class="w-full" />
        </image-with-action>
      </div>
      <div v-if="mode === 'spot-zoom'" ref="imageRef">
        <image-with-action :photo="selectedPhoto" :can-go-next="canGoNext" :can-go-prev="canGoPrev" @next="goNext"
          @prev="goPrev" @fullscreen="toggleFullScreen">
          <a-empty v-if="!selectedPhoto.path" description="No image available" />
          <vue-magnifier v-else :src="selectedPhoto.path" :mgWidth="300" :mgHeight="300" />
        </image-with-action>
      </div>
      <div v-if="mode === 'zoom-in'" ref="imageRef">
        <image-with-action :photo="selectedPhoto" :can-go-next="canGoNext" :can-go-prev="canGoPrev" @next="goNext"
          @prev="goPrev" @fullscreen="toggleFullScreen">
          <a-empty v-if="!selectedPhoto.path" description="No image available" />
          <panzoom v-else>
            <img :src="selectedPhoto.path" :alt="selectedPhoto.title || 'Zoomable Image'" class="w-full" />
          </panzoom>
        </image-with-action>
      </div>
    </div>

    <div class="mt-5 px-4">
      <div class="flex justify-between items-center flex-wrap md:flex-nowrap gap-2">
        <div>
          <label class="block mb-3 text-sm font-medium">Photos Date: </label>
          <a-date-picker v-model:value="selectedDate" class="w-56" :disabled-date="getDisableDates" />
        </div>
        <a-popconfirm v-if="canDeletePhoto" title="Are you sure to delete this photo?" @confirm="handleImageDelete">
          <a-button class="bg-red-500 hover:bg-red-600 text-white" type="danger">
            Delete This Photo
          </a-button>
        </a-popconfirm>
      </div>
      <image-slider :photos="photos" :selected="selectedPhoto.id" @onSelect="handleImageSelect" />
    </div>
    <feedback :selected-photo="selectedPhoto" />
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue'
import axios from 'axios'
import dayjs from 'dayjs'
import ImageWithAction from '../ImageWithAction.vue'
import VueMagnifier from '@websitebeaver/vue-magnifier'
import '@websitebeaver/vue-magnifier/styles.css'
import ImageSlider from '../ImageSlider.vue'
import Feedback from '../Feedback.vue'
import Panzoom from '../../../../Panzoom.vue'

const props = defineProps({
  camera: {
    type: Object,
    required: true
  },
  user: {
    type: Object,
    required: true
  },
  lastCapturedAt: {
    type: String,
    required: false,
  },
  mode: {
    type: String,
    default: 'single-view'
  },
  selectedImage: {
    type: Object,
    default: null
  },
  showFullScreen: {
    type: Boolean,
    default: false
  },
  showMainImage: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['onImageChange'])

const imageRef = ref(null)
const photos = ref([])
const disabledDates = ref([])
const selectedDate = ref(dayjs(props?.lastCapturedAt))
const selectedPhoto = ref({})

const currentPhotoIndex = computed(() => {
  return photos.value.findIndex(photo => photo.id === selectedPhoto.value.id)
})

const canGoNext = computed(() => {
  return currentPhotoIndex.value >= 0 && currentPhotoIndex.value < photos.value.length - 1
})

const canGoPrev = computed(() => {
  return currentPhotoIndex.value > 0
})

const canDeletePhoto = computed(() => {
  return ['super_admin', 'admin', 'project_admin'].includes(props.user?.role) &&
    props.mode === 'single-view' &&
    selectedPhoto.value.path
})

const getPhotos = async () => {
  try {
    const { data: { photos: dbPhotos, dates } } = await axios.post(`/camera/${props.camera.id}/photos`, {
      date: selectedDate.value.format('YYYY-MM-DD')
    })

    photos.value = dbPhotos
    disabledDates.value = dates

    if (dbPhotos.length > 0) {
      if (props.selectedImage) {
        getSelectedImage()
      } else {
        selectedPhoto.value = dbPhotos[0]
      }
    } else {
      selectedPhoto.value = {}
    }
  } catch (error) {
    console.error('Failed to fetch photos:', error)
  }
}

const toggleFullScreen = () => {
  imageRef.value.requestFullscreen()
}

const handleImageDelete = async () => {
  try {
    await axios.delete(`/camera/${props.camera.id}/photos/${selectedPhoto.value.id}`)
    photos.value = photos.value.filter(photo => photo.id !== selectedPhoto.value.id)
  } catch (error) {
    console.error('Failed to delete photo:', error)
  }
}

const getDisableDates = (current) => {
  const formattedDate = dayjs(current).format('YYYY-MM-DD')
  return disabledDates.value.includes(formattedDate)
}

const handleImageSelect = (photo) => {
  selectedPhoto.value = photo
  emit('onImageChange', photo.path)
}

const goNext = () => {
  if (canGoNext.value) {
    selectedPhoto.value = photos.value[currentPhotoIndex.value + 1]
    emit('onImageChange', selectedPhoto.value.path)
  }
}

const goPrev = () => {
  if (canGoPrev.value) {
    selectedPhoto.value = photos.value[currentPhotoIndex.value - 1]
    emit('onImageChange', selectedPhoto.value.path)
  }
}

const getSelectedImage = () => {
  if (props.selectedImage) {
    const photo = photos.value.find(photo => photo.path === props.selectedImage)
    selectedPhoto.value = photo
  }
}

onMounted(async () => {
  await getPhotos()
  emit('onImageChange', selectedPhoto.value.path)
})

watch(selectedDate, () => {
  getPhotos()
})
</script>
