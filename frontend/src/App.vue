<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const isLoggedIn = ref(false)
const router = useRouter()

function checkLogin() {
  isLoggedIn.value = !!localStorage.getItem('token')
}

onMounted(() => {
  checkLogin()
})

const logout = () => {
  localStorage.removeItem('token')
  checkLogin()
  router.push('/login')
}
</script>

<template>
  <div class="app-container">
    <nav class="navigation">
      <router-link to="/" class="nav-brand">WroomWroomMe</router-link>
      <div class="nav-links">
        <template v-if="isLoggedIn">
          <!-- Navigation for logged-in user -->
          <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
          <button @click="logout" class="nav-link logout">Logout</button>
        </template>
        <template v-else>
          <!-- Navigation for guest -->
          <router-link to="/about-me" class="nav-link">About Me</router-link>
          <router-link to="/login" class="nav-link">Login</router-link>
          <router-link to="/register" class="nav-link">Register</router-link>
        </template>
      </div>
    </nav>
    <router-view v-slot="{ Component }">
      <component :is="Component" />
    </router-view>
  </div>
</template>

<style>
.app-container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.navigation {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  margin-bottom: 2rem;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nav-brand {
  font-size: 1.5rem;
  font-weight: bold;
  color: #2c3e50;
  text-decoration: none;
}

.nav-links {
  display: flex;
  gap: 1rem;
}

.nav-link {
  padding: 0.5rem 1rem;
  text-decoration: none;
  color: #2c3e50;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.nav-link:hover {
  background-color: #f8f9fa;
}

.logout {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1rem;
}

.logout:hover {
  color: #dc3545;
}
</style>