<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

type Festival = {
  id: number;
  title: string;
  organizer: string;
  event_date: string;
  time: string;
  location: {
    venue: string;
    location: string;
    city: string;
  };
  description: string;
};

const festivals = ref<Festival[]>([])

onMounted(async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/car-shows');
    console.log('API Response:', response.data); // Log the entire response data
    festivals.value = response.data; // Directly assign the array to festivals.value
    console.log('Fetched car shows:', festivals.value);
  } catch (error) {
    console.error('Error fetching car shows:', error);
  }
});

</script>

<template>
  <div class="festivals-container">
    <h1 class="main-title">Upcoming Car Festivals</h1>
    
    <div class="festivals-grid">
      <div v-for="festival in festivals" :key="festival.id" class="festival-card">
        <h2 class="festival-title">{{ festival.title }}</h2>
        
        
        
        <div class="festival-info">
          <div class="info-section">
            <h3>Organizer</h3>
            <p>{{ festival.organizer }}</p>
          </div>

          <div class="info-section">
            <h3>When</h3>
            <p>{{ festival.event_date }}</p>
            <p>{{ festival.time }}</p>
          </div>

          <div class="info-section">
            <h3>Where</h3>
            <p>{{ festival.location }}</p>

          </div>

          <div class="info-section">
            <h3>About the Event</h3>
            <p class="description">{{ festival.description.slice(0, 150) }}...</p>
          </div>
        </div>

        <div class="action-buttons">
          <button class="btn going">
            I'm in

          </button>
          <button  class="btn interested">
            Interesting
           </button>
          <button  class="btn share">
            Share
          </button>
          <button  class="btn learn-more">
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