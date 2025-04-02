import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { ActivityLog } from '../types'

export const useActivityStore = defineStore('activity', () => {
  const logs = ref<ActivityLog[]>([])

  const logActivity = ({ userId, action, details }: Omit<ActivityLog, 'id' | 'timestamp' | 'ipAddress'>) => {
    const log: ActivityLog = {
      id: crypto.randomUUID(),
      userId,
      action,
      details,
      timestamp: new Date(),
      ipAddress: '127.0.0.1' // In a real app, this would come from the server
    }
    
    logs.value.unshift(log)
  }

  const getLogs = (limit?: number) => {
    return limit ? logs.value.slice(0, limit) : logs.value
  }

  const clearLogs = () => {
    logs.value = []
  }

  return {
    logs,
    logActivity,
    getLogs,
    clearLogs
  }
})