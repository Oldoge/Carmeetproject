<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import ImageSlider from './ImageSlider.vue'

const router = useRouter()

interface Festival {
  id: number
  name: string
  organizer: string
  dates: string
  time: string
  location: {
    venue: string
    address: string
    city: string
  }
  description: string
  interestedCount: number
  goingCount: number
  images: Array<{
    url: string
    alt: string
  }>
}

const festivals = ref<Festival[]>([
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
        url: "",
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
  {
    id: 2,
    name: "Vintage Auto Show 2024",
    organizer: "Classic Car Preservation Society",
    dates: "June 22-24, 2024",
    time: "9:00 AM - 6:00 PM",
    location: {
      venue: "Heritage Park",
      address: "456 Classic Drive",
      city: "San Francisco, CA"
    },
    description: "Step back in time with our annual Vintage Auto Show! Featuring pristine classic cars from the 1920s to 1970s, restoration workshops, period-correct exhibitions, and classic car auctions. Special focus on American and European classics.",
    interestedCount: 0,
    goingCount: 0,
    images: [
      {
        url: "https://images.unsplash.com/photo-1566013656433-e818796d04f7?auto=format&fit=crop&w=800",
        alt: "Classic American car"
      },
      {
        url: "https://images.unsplash.com/photo-1591293835940-934a7c4f2d9b?auto=format&fit=crop&w=800",
        alt: "Vintage European automobile"
      },
      {
        url: "https://images.unsplash.com/photo-1567899378494-47b22a2ae96a?auto=format&fit=crop&w=800",
        alt: "Retro car meeting"
      }
    ]
  },
  {
    id: 3,
    name: "Future Motors Expo 2024",
    organizer: "Tech Automotive Association",
    dates: "October 5-7, 2024",
    time: "10:00 AM - 9:00 PM",
    location: {
      venue: "Innovation Center",
      address: "789 Technology Blvd",
      city: "Austin, TX"
    },
    description: "Experience the future of automotive technology! Showcasing electric vehicles, autonomous cars, sustainable mobility solutions, and cutting-edge automotive innovations. Features interactive demos, test drives, and talks from industry leaders.",
    interestedCount: 0,
    goingCount: 0,
    images: [
      {
        url: "https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=800",
        alt: "Electric vehicle showcase"
      },
      {
        url: "https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800",
        alt: "Modern electric car interior"
      },
      {
        url: "https://images.unsplash.com/photo-1593941707882-a5bba14938c7?auto=format&fit=crop&w=800",
        alt: "Future concept car"
      }
    ]
  }
])

const handleInterested = (festivalId: number) => {
  const festival = festivals.value.find(f => f.id === festivalId)
  if (festival) {
    festival.interestedCount++
  }
}

const handleGoing = (festivalId: number) => {
  const festival = festivals.value.find(f => f.id === festivalId)
  if (festival) {
    festival.goingCount++
  }
}

const handleShare = async (festival: Festival) => {
  try {
    await navigator.share({
      title: festival.name,
      text: `Join us at ${festival.name}! ${festival.description}`,
      url: window.location.href
    })
  } catch (err) {
    alert('Share this page URL with your friends!')
  }
}

const navigateToDetails = (festivalId: number) => {
  router.push(`/event/${festivalId}`)
}
</script>

<template>
  <div class="festivals-container">
    <h1 class="main-title">Upcoming Car Festivals</h1>
    
    <div class="festivals-grid">
      <div v-for="festival in festivals" :key="festival.id" class="festival-card">
        <h2 class="festival-title">{{ festival.name }}</h2>
        
        <ImageSlider :images="festival.images" />
        
        <div class="festival-info">
          <div class="info-section">
            <h3>Organizer</h3>
            <p>{{ festival.organizer }}</p>
          </div>

          <div class="info-section">
            <h3>When</h3>
            <p>{{ festival.dates }}</p>
            <p>{{ festival.time }}</p>
          </div>

          <div class="info-section">
            <h3>Where</h3>
            <p>{{ festival.location.venue }}</p>
            <p>{{ festival.location.address }}</p>
            <p>{{ festival.location.city }}</p>
          </div>

          <div class="info-section">
            <h3>About the Event</h3>
            <p class="description">{{ festival.description.slice(0, 150) }}...</p>
          </div>
        </div>

        <div class="action-buttons">
          <button @click="handleGoing(festival.id)" class="btn going">
            I'm in
            <span v-if="festival.goingCount > 0" class="counter">{{ festival.goingCount }}</span>
          </button>
          <button @click="handleInterested(festival.id)" class="btn interested">
            Interesting
            <span v-if="festival.interestedCount > 0" class="counter">{{ festival.interestedCount }}</span>
          </button>
          <button @click="handleShare(festival)" class="btn share">
            Share
          </button>
          <button @click="navigateToDetails(festival.id)" class="btn learn-more">
            Learn More
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.festivals-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.main-title {
  color: #2c3e50;
  font-size: 2.5rem;
  text-align: center;
  margin-bottom: 3rem;
}

.festivals-grid {
  display: grid;
  gap: 2rem;
  grid-template-columns: 1fr;
}

@media (min-width: 1024px) {
  .festivals-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.festival-card {
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.festival-title {
  color: #2c3e50;
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
  text-align: center;
}

.festival-info {
  display: grid;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.info-section {
  background: #f8f9fa;
  padding: 1.2rem;
  border-radius: 8px;
}

.info-section h3 {
  color: #2c3e50;
  font-size: 1.2rem;
  margin-bottom: 0.8rem;
}

.info-section p {
  color: #4a5568;
  line-height: 1.6;
  margin: 0.4rem 0;
}

.description {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.action-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
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

.learn-more {
  background: #FF5722;
  color: white;
}

.counter {
  background: rgba(255, 255, 255, 0.2);
  padding: 0.2rem 0.6rem;
  border-radius: 12px;
  font-size: 0.9rem;
}
</style>