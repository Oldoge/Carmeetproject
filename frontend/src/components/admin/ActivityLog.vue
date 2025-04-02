<script setup lang="ts">
import { computed } from 'vue'
import { useActivityStore } from '../../stores/activity'
import { format } from 'date-fns'

const activityStore = useActivityStore()

const recentLogs = computed(() => {
  return activityStore.getLogs(50)
})
</script>

<template>
  <div class="activity-log">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Activity</h2>
    
    <div class="log-entries">
      <div v-for="log in recentLogs" :key="log.id" class="log-entry">
        <div class="log-time">
          {{ format(log.timestamp, 'HH:mm:ss') }}
        </div>
        <div class="log-content">
          <span class="log-action">{{ log.action }}</span>
          <p class="log-details">{{ log.details }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.activity-log {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.log-entries {
  max-height: 600px;
  overflow-y: auto;
}

.log-entry {
  display: flex;
  gap: 1rem;
  padding: 0.75rem;
  border-bottom: 1px solid #e2e8f0;
}

.log-time {
  color: #64748b;
  font-size: 0.875rem;
  white-space: nowrap;
}

.log-content {
  flex: 1;
}

.log-action {
  font-weight: 500;
  color: #2563eb;
}

.log-details {
  color: #4b5563;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}
</style>