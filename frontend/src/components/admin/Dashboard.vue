<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { useActivityStore } from '../../stores/activity'
import UserList from './UserList.vue'
import ActivityLog from './ActivityLog.vue'
import { format } from 'date-fns'

const authStore = useAuthStore()
const activityStore = useActivityStore()

const stats = ref({
  totalUsers: 0,
  activeUsers: 0,
  organizers: 0,
  regularUsers: 0
})

onMounted(() => {
  const users = authStore.getAllUsers()
  stats.value = {
    totalUsers: users.length,
    activeUsers: users.filter(u => u.status === 'active').length,
    organizers: users.filter(u => u.role === 'organizer').length,
    regularUsers: users.filter(u => u.role === 'user').length
  }
})
</script>

<template>
  <div class="admin-dashboard">
    <header class="dashboard-header">
      <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
      <p class="text-gray-600">Welcome back, {{ authStore.user?.name }}</p>
    </header>

    <div class="stats-grid">
      <div class="stat-card">
        <h3>Total Users</h3>
        <p class="stat-value">{{ stats.totalUsers }}</p>
      </div>
      <div class="stat-card">
        <h3>Active Users</h3>
        <p class="stat-value">{{ stats.activeUsers }}</p>
      </div>
      <div class="stat-card">
        <h3>Organizers</h3>
        <p class="stat-value">{{ stats.organizers }}</p>
      </div>
      <div class="stat-card">
        <h3>Regular Users</h3>
        <p class="stat-value">{{ stats.regularUsers }}</p>
      </div>
    </div>

    <div class="dashboard-content">
      <UserList />
      <ActivityLog />
    </div>
  </div>
</template>

<style scoped>
.admin-dashboard {
  padding: 2rem;
}

.dashboard-header {
  margin-bottom: 2rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.stat-card h3 {
  color: #64748b;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.stat-value {
  color: #1e293b;
  font-size: 1.5rem;
  font-weight: 600;
}

.dashboard-content {
  display: grid;
  gap: 2rem;
}

@media (min-width: 1024px) {
  .dashboard-content {
    grid-template-columns: 2fr 1fr;
  }
}
</style>