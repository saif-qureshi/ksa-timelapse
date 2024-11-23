<template>
  <div>
    <div class="image-wrapper">
      <!-- Single Mode -->
      <div class="relative" v-if="mode === 'single' && !['spot-zoom','spot-compare'].includes(mode)">
        <!-- Fullscreen Button -->
        <a-button
          v-if="selectedPhoto.path && showFullScreen"
          class="absolute right-2 top-8 z-10 bg-black hover:bg-black/80 flex gap-x-2"
          type="primary"
          @click="toggleFullScreen"
        >
          <Icon name="Fullscreen" :size="20" color="#fff" />
          Full Screen
        </a-button>

        <!-- Main Image Container -->
        <div class="relative" ref="imageRef">
          <a-empty
            v-if="!selectedPhoto.path"
            description="No image available"
          />
          <img 
            v-else 
            :src="selectedPhoto.path" 
            :alt="selectedPhoto.title || 'Image'"
            class="w-full" 
          />
          
          <!-- Navigation Buttons -->
          <a-button
            v-if="selectedPhoto.path"
            class="bg-black text-white shadow-md absolute top-1/2 -translate-y-1/2 left-4 h-10 w-10 flex justify-center items-center rounded-full p-0 transition-opacity hover:bg-black/80"
            :disabled="!canGoPrev"
            @click="goPrev"
          >
            <Icon name="ArrowLeft" size="16" />
          </a-button>
          <a-button
            v-if="selectedPhoto.path"
            class="bg-black text-white shadow-md absolute top-1/2 -translate-y-1/2 right-4 h-10 w-10 flex justify-center items-center rounded-full p-0 transition-opacity hover:bg-black/80"
            :disabled="!canGoNext"
            @click="goNext"
          >
            <Icon name="ArrowRight" size="16" />
          </a-button>
        </div>

        <!-- Fullscreen Modal -->
        <Teleport to="body">
          <div 
            v-if="showFullScreen" 
            class="full-screen-overlay"
            @click.self="closeFullScreen"
          >
            <div class="full-screen-container">
              <a-button
                class="absolute top-4 right-4 bg-black/50 hover:bg-black/70"
                @click="closeFullScreen"
              >
                <Icon name="X" :size="24" color="#fff" />
              </a-button>
              <img
                v-if="selectedPhoto.path"
                :src="selectedPhoto.path"
                :alt="selectedPhoto.title || 'Full Screen Image'"
                class="max-w-full max-h-screen object-contain"
              />
            </div>
          </div>
        </Teleport>
      </div>

      <!-- Spot Zoom Mode -->
      <div v-else-if="mode === 'spot-zoom'">
        <a-empty v-if="!selectedPhoto.path" description="No image available" />
        <VueMagnifier
          v-else
          :src="selectedPhoto.path"
          :mgWidth="300"
          :mgHeight="300"
        />
      </div>

      <!-- Zoom Mode -->
      <div v-else-if="mode === 'zoom'">
        <a-empty v-if="!selectedPhoto.path" description="No image available" />
        <Panzoom v-else>
          <img :src="selectedPhoto.path" :alt="selectedPhoto.title || 'Zoomable Image'" class="w-full" />
        </Panzoom>
      </div>
    </div>

    <!-- Controls Section -->
    <div class="mt-5 px-4">
      <div class="flex justify-between items-center">
        <!-- Date Picker -->
        <div>
          <label class="block mb-3 text-sm font-medium">Photos Date: </label>
          <a-date-picker
            v-model:value="selectedDate"
            class="w-56"
            :disabled-date="getDisableDates"
          />
        </div>

        <!-- Delete Button -->
        <a-popconfirm
          v-if="canDeletePhoto"
          title="Are you sure to delete this photo?"
          @confirm="handleImageDelete"
        >
          <a-button
            class="bg-red-500 hover:bg-red-600 text-white"
            type="danger"
          >
            Delete This Photo
          </a-button>
        </a-popconfirm>
      </div>
      <ImageSlider
        :photos="photos"
        :selected="selectedPhoto.id"
        @onSelect="handleImageSelect"
      />
    </div>

    <!-- Feedback Component -->
    <Feedback :selectedPhoto="selectedPhoto" />
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue'
import axios from 'axios'
import dayjs from 'dayjs'
import Icon from '../../../../Icon.vue'
import VueMagnifier from '@websitebeaver/vue-magnifier'
import '@websitebeaver/vue-magnifier/styles.css'
import ImageSlider from '../ImageSlider.vue'
import Feedback from '../Feedback.vue'
import Panzoom from '../../../../Panzoom.vue'

// Props
const props = defineProps({
  camera: {
    type: Object,
    required: true
  },
  user: {
    type: Object,
    required: true
  },
  mode: {
    type: String,
    default: 'single'
  },
  showFullScreen: {
    type: Boolean,
    default: false
  }
})

// Emits
const emit = defineEmits(['onImageChange'])

// Refs
const imageRef = ref(null)
const photos = ref([])
const disabledDates = ref([])
const selectedDate = ref(dayjs())
const selectedPhoto = ref({})
const showFullScreen = ref(false)

// Computed
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
         props.mode === 'single' && 
         selectedPhoto.value.path
})

// Methods
const getPhotos = async () => {
  try {
    const { data: { photos: dbPhotos, dates } } = await axios.post(`/camera/${props.camera.id}/photos`, {
      date: selectedDate.value.format('YYYY-MM-DD')
    })
    
    photos.value = dbPhotos
    disabledDates.value = dates
    
    if (dbPhotos.length > 0) {
      selectedPhoto.value = dbPhotos[0]
    } else {
      selectedPhoto.value = {}
    }
  } catch (error) {
    console.error('Failed to fetch photos:', error)
  }
}

const toggleFullScreen = () => {
  showFullScreen.value = !showFullScreen.value
}

const closeFullScreen = () => {
  showFullScreen.value = false
}

const handleImageDelete = async () => {
  try {
    await axios.delete(`/camera/${props.camera.id}/photos/${selectedPhoto.value.id}`)
    await getPhotos()
  } catch (error) {
    console.error('Failed to delete photo:', error)
  }
}

const getDisableDates = (current) => {
  return !disabledDates.value.includes(dayjs(current).format('YYYY-MM-DD'))
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

// Lifecycle
onMounted(async () => {
  await getPhotos()
  emit('onImageChange', selectedPhoto.value.path)
})

// Watchers
watch(selectedDate, () => {
  getPhotos()
})
</script>

<style scoped>
.full-screen-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.9);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 50;
}

.full-screen-container {
  position: relative;
  max-width: 95vw;
  max-height: 95vh;
  overflow: hidden;
}

.full-screen-container img {
  display: block;
  max-width: 100%;
  max-height: 95vh;
  object-fit: contain;
}
</style>