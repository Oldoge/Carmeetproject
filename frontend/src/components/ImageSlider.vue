<script setup lang="ts">
import { ref } from 'vue'

const props = defineProps<{
  images: Array<{
    url: string
    alt: string
  }>
}>()

const currentIndex = ref(0)

const next = () => {
  currentIndex.value = (currentIndex.value + 1) % props.images.length
}

const prev = () => {
  currentIndex.value = currentIndex.value === 0 
    ? props.images.length - 1 
    : currentIndex.value - 1
}
</script>

<template>
  <div class="slider-container">
    <button @click="prev" class="slider-button prev" aria-label="Previous image">
      &#10094;
    </button>
    
    <div class="image-container">
      <img 
        :src="images[currentIndex].url" 
        :alt="images[currentIndex].alt"
        class="slider-image"
      />
      <div class="image-counter">
        {{ currentIndex + 1 }} / {{ images.length }}
      </div>
    </div>
    
    <button @click="next" class="slider-button next" aria-label="Next image">
      &#10095;
    </button>
  </div>
</template>

<style scoped>
.slider-container {
  position: relative;
  width: 100%;
  height: 300px;
  margin-bottom: 1.5rem;
  border-radius: 8px;
  overflow: hidden;
}

.image-container {
  width: 100%;
  height: 100%;
  position: relative;
}

.slider-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: opacity 0.3s ease;
}

.slider-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 1rem;
  cursor: pointer;
  z-index: 2;
  transition: background-color 0.3s;
}

.slider-button:hover {
  background: rgba(0, 0, 0, 0.7);
}

.prev {
  left: 0;
  border-radius: 0 4px 4px 0;
}

.next {
  right: 0;
  border-radius: 4px 0 0 4px;
}

.image-counter {
  position: absolute;
  bottom: 1rem;
  right: 1rem;
  background: rgba(0, 0, 0, 0.6);
  color: white;
  padding: 0.3rem 0.8rem;
  border-radius: 12px;
  font-size: 0.9rem;
}
</style>