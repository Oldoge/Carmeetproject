<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import type { Festival } from '../types'

const authStore = useAuthStore()
const router = useRouter()

// New festival form data
const newFestival = ref({
  name: '',
  organizer: '',
  dates: '',
  time: '',
  location: {
    venue: '',
    address: '',
    city: ''
  },
  description: '',
  images: [{ url: '', alt: '' }]
})

const addFestival = () => {
  // Here you would typically make an API call to add the festival
  console.log('Adding new festival:', newFestival.value)
  alert('Festival added successfully!')
  // Reset form
  newFestival.value = {
    name: '',
    organizer: '',
    dates: '',
    time: '',
    location: {
      venue: '',
      address: '',
      city: ''
    },
    description: '',
    images: [{ url: '', alt: '' }]
  }
}

const addImageField = () => {
  newFestival.value.images.push({ url: '', alt: '' })
}

const removeImageField = (index: number) => {
  newFestival.value.images.splice(index, 1)
}
</script>

<template>
  <div class="admin-panel">
    <div class="admin-header">
      <h1>Admin Panel</h1>
      <p>Welcome, {{ authStore.user?.email }}</p>
    </div>

    <div class="admin-content">
      <div class="card">
        <h2>Add New Festival</h2>
        <form @submit.prevent="addFestival" class="festival-form">
          <div class="form-group">
            <label for="name">Festival Name</label>
            <input
              type="text"
              id="name"
              v-model="newFestival.name"
              required
            />
          </div>

          <div class="form-group">
            <label for="organizer">Organizer</label>
            <input
              type="text"
              id="organizer"
              v-model="newFestival.organizer"
              required
            />
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="dates">Dates</label>
              <input
                type="text"
                id="dates"
                v-model="newFestival.dates"
                required
              />
            </div>

            <div class="form-group">
              <label for="time">Time</label>
              <input
                type="text"
                id="time"
                v-model="newFestival.time"
                required
              />
            </div>
          </div>

          <div class="form-group">
            <label for="venue">Venue</label>
            <input
              type="text"
              id="venue"
              v-model="newFestival.location.venue"
              required
            />
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <input
              type="text"
              id="address"
              v-model="newFestival.location.address"
              required
            />
          </div>

          <div class="form-group">
            <label for="city">City</label>
            <input
              type="text"
              id="city"
              v-model="newFestival.location.city"
              required
            />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea
              id="description"
              v-model="newFestival.description"
              required
              rows="4"
            ></textarea>
          </div>

          <div class="images-section">
            <div class="images-header">
              <h3>Festival Images</h3>
              <button type="button" @click="addImageField" class="btn-secondary">
                Add Image
              </button>
            </div>

            <div v-for="(image, index) in newFestival.images" :key="index" class="image-fields">
              <div class="form-group">
                <label :for="'image-url-' + index">Image URL</label>
                <input
                  :id="'image-url-' + index"
                  type="url"
                  v-model="image.url"
                  required
                  placeholder="https://example.com/image.jpg"
                />
              </div>
              <div class="form-group">
                <label :for="'image-alt-' + index">Image Alt Text</label>
                <input
                  :id="'image-alt-' + index"
                  type="text"
                  v-model="image.alt"
                  required
                  placeholder="Description of the image"
                />
              </div>
              <button 
                type="button" 
                @click="removeImageField(index)"
                class="btn-danger"
                v-if="newFestival.images.length > 1"
              >
                Remove
              </button>
            </div>
          </div>

          <button type="submit" class="btn-primary">Add Festival</button>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.admin-panel {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.admin-header {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  margin-bottom: 2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.admin-header h1 {
  margin: 0;
  color: #2c3e50;
}

.admin-header p {
  margin: 0.5rem 0 0;
  color: #666;
}

.card {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card h2 {
  margin: 0 0 1.5rem;
  color: #2c3e50;
}

.festival-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

label {
  font-weight: 500;
  color: #4a5568;
}

input, textarea {
  padding: 0.75rem;
  border: 1px solid #e2e8f0;
  border-radius: 4px;
  font-size: 1rem;
}

input:focus, textarea:focus {
  outline: none;
  border-color: #2196F3;
  box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
}

.images-section {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 8px;
}

.images-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.images-header h3 {
  margin: 0;
  color: #2c3e50;
}

.image-fields {
  display: grid;
  gap: 1rem;
  padding: 1rem;
  background: white;
  border-radius: 4px;
  margin-bottom: 1rem;
  position: relative;
}

.btn-primary {
  background: #2196F3;
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-primary:hover {
  background: #1976D2;
}

.btn-secondary {
  background: #4CAF50;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-secondary:hover {
  background: #388E3C;
}

.btn-danger {
  background: #dc3545;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-danger:hover {
  background: #c82333;
}
</style>