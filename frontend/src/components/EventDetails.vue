<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import type { Festival } from '../types'
import ImageSlider from './ImageSlider.vue'

const props = defineProps<{
  id: string
}>()

const router = useRouter()
const festival = ref<Festival | null>(null)

onMounted(() => {
  // In a real app, this would be an API call
  const festivalId = parseInt(props.id)
  festival.value = festivals.find(f => f.id === festivalId) || null
  
  if (!festival.value) {
    router.push('/')
  }
})

// Mock data (in a real app, this would come from an API)
const festivals: Festival[] = [
  {
    id: 1,
    name: "MotorMania 2024",
    organizer: "MotorMania Events & Classic Car Club Association",
    dates: "August 15-17, 2024",
    time: "10:00 AM - 8:00 PM",
    location: {
      venue: "Central Exhibition Center",
      address: "123 Motorway Avenue",
      city: "Los Angeles, CA"
    },
    description: "Join us for the most spectacular car festival of the year! MotorMania 2024 brings together classic cars, modern supercars, and innovative concept vehicles. Experience live demonstrations, meet car enthusiasts, enjoy food trucks, and participate in exclusive workshops with automotive experts.",
    interestedCount: 0,
    goingCount: 0,
    images: [
      {
        url: "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=800",
        alt: "Luxury sports car at sunset"
      },
      {
        url: "https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800",
        alt: "Classic car exhibition"
      },
      {
        url: "https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800",
        alt: "Vintage car showcase"
      }
    ]
  },
  // ... other festivals
]
</script>

<template>
  <div v-if="festival" class="event-details">
    <div class="event-header">
      <h1>{{ festival.name }}</h1>
      <p class="organizer">Organized by {{ festival.organizer }}</p>
    </div>

    <div class="event-content">
      <div class="main-content">
        <ImageSlider :images="festival.images" class="event-slider" />

        <div class="event-info">
          <div class="info-section">
            <h2>Event Details</h2>
            <div class="info-grid">
              <div>
                <h3>When</h3>
                <p>{{ festival.dates }}</p>
                <p>{{ festival.time }}</p>
              </div>
              <div>
                <h3>Where</h3>
                <p>{{ festival.location.venue }}</p>
                <p>{{ festival.location.address }}</p>
                <p>{{ festival.location.city }}</p>
              </div>
            </div>
          </div>

          <div class="info-section">
            <h2>About the Event</h2>
            <p class="description">{{ festival.description }}</p>
          </div>
        </div>

        <div class="action-buttons">
          <button class="btn going">
            I'm Going
            <span v-if="festival.goingCount > 0" class="counter">{{ festival.goingCount }}</span>
          </button>
          <button class="btn interested">
            Interested
            <span v-if="festival.interestedCount > 0" class="counter">{{ festival.interestedCount }}</span>
          </button>
          <button class="btn share">Share</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.event-details {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.event-header {
  text-align: center;
  margin-bottom: 2rem;
}

.event-header h1 {
  font-size: 2.5rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.organizer {
  color: #64748b;
  font-size: 1.1rem;
}

.event-content {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.main-content {
  padding: 2rem;
}

.event-slider {
  margin-bottom: 2rem;
  height: 400px;
}

.event-info {
  display: grid;
  gap: 2rem;
}

.info-section {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 8px;
}

.info-section h2 {
  color: #2c3e50;
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
}

.info-grid h3 {
  color: #64748b;
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
}

.info-grid p {
  color: #1e293b;
  margin: 0.25rem 0;
}

.description {
  color: #4b5563;
  line-height: 1.6;
}

.action-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 2rem;
  flex-wrap: wrap;
}

.btn {
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  font-size: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: transform 0.2s;
}

.btn:hover {
  transform: translateY(-2px);
}

.going {
  background: #4CAF50;
  color: white;
}

.interested {
  background: #2196F3;
  color: white;
}

.share {
  background: #9C27B0;
  color: white;
}

.counter {
  background: rgba(255, 255, 255, 0.2);
  padding: 0.2rem 0.6rem;
  border-radius: 12px;
  font-size: 0.9rem;
}
</style>