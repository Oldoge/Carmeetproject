<script setup lang="ts">
import { ref, computed } from 'vue'
import { useAuthStore } from '../../stores/auth'
import type { User, UserFilters } from '../../types'
import { format } from 'date-fns'
import { useToast } from 'vue-toastification'

const authStore = useAuthStore()
const toast = useToast()

const filters = ref<UserFilters>({
  role: undefined,
  status: undefined,
  search: '',
  sortBy: 'createdAt',
  sortOrder: 'desc'
})

const selectedUsers = ref<Set<string>>(new Set())

const users = computed(() => {
  return authStore.getAllUsers(filters.value)
})

const handleUpdateUser = async (user: User, updates: Partial<User>) => {
  try {
    await authStore.updateUser(user.id, updates)
    toast.success('User updated successfully')
  } catch (error) {
    toast.error('Failed to update user')
  }
}

const handleDeleteUser = async (userId: string) => {
  if (!confirm('Are you sure you want to delete this user?')) return
  
  try {
    await authStore.deleteUser(userId)
    selectedUsers.value.delete(userId)
    toast.success('User deleted successfully')
  } catch (error) {
    toast.error('Failed to delete user')
  }
}

const handleBulkDelete = async () => {
  if (!confirm(`Are you sure you want to delete ${selectedUsers.value.size} users?`)) return
  
  try {
    for (const userId of selectedUsers.value) {
      await authStore.deleteUser(userId)
    }
    selectedUsers.value.clear()
    toast.success('Users deleted successfully')
  } catch (error) {
    toast.error('Failed to delete some users')
  }
}

const toggleSelectAll = (event: Event) => {
  const checked = (event.target as HTMLInputElement).checked
  if (checked) {
    users.value.forEach(user => selectedUsers.value.add(user.id))
  } else {
    selectedUsers.value.clear()
  }
}

const toggleSelectUser = (userId: string) => {
  if (selectedUsers.value.has(userId)) {
    selectedUsers.value.delete(userId)
  } else {
    selectedUsers.value.add(userId)
  }
}
</script>

<template>
  <div class="user-list">
    <div class="list-header">
      <h2 class="text-xl font-semibold text-gray-900">User Management</h2>
      
      <div class="filters">
        <input
          type="text"
          v-model="filters.search"
          placeholder="Search users..."
          class="search-input"
        />
        
        <select v-model="filters.role" class="filter-select">
          <option value="">All Roles</option>
          <option value="admin">Admin</option>
          <option value="organizer">Organizer</option>
          <option value="user">Regular User</option>
        </select>
        
        <select v-model="filters.status" class="filter-select">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="suspended">Suspended</option>
        </select>
      </div>
    </div>

    <div class="bulk-actions" v-if="selectedUsers.size > 0">
      <button
        @click="handleBulkDelete"
        class="btn-danger"
      >
        Delete Selected ({{ selectedUsers.size }})
      </button>
    </div>

    <div class="users-table">
      <table>
        <thead>
          <tr>
            <th>
              <input
                type="checkbox"
                @change="toggleSelectAll"
                :checked="selectedUsers.size === users.length"
              />
            </th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created</th>
            <th>Last Login</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>
              <input
                type="checkbox"
                :checked="selectedUsers.has(user.id)"
                @change="toggleSelectUser(user.id)"
              />
            </td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>
              <select
                v-model="user.role"
                @change="handleUpdateUser(user, { role: user.role })"
                :disabled="user.role === 'admin'"
              >
                <option value="admin">Admin</option>
                <option value="organizer">Organizer</option>
                <option value="user">Regular User</option>
              </select>
            </td>
            <td>
              <select
                v-model="user.status"
                @change="handleUpdateUser(user, { status: user.status })"
                :disabled="user.role === 'admin'"
              >
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
              </select>
            </td>
            <td>{{ format(user.createdAt, 'MMM d, yyyy') }}</td>
            <td>{{ user.lastLogin ? format(user.lastLogin, 'MMM d, yyyy HH:mm') : 'Never' }}</td>
            <td>
              <button
                @click="handleDeleteUser(user.id)"
                class="btn-danger"
                :disabled="user.role === 'admin'"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.user-list {
  background: white;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.list-header {
  margin-bottom: 1.5rem;
}

.filters {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
  flex-wrap: wrap;
}

.search-input,
.filter-select {
  padding: 0.5rem;
  border: 1px solid #e2e8f0;
  border-radius: 4px;
  min-width: 150px;
}

.bulk-actions {
  margin-bottom: 1rem;
}

.users-table {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
}

th {
  background: #f8fafc;
  font-weight: 600;
}

.btn-danger {
  background: #ef4444;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  border: none;
  cursor: pointer;
}

.btn-danger:hover:not(:disabled) {
  background: #dc2626;
}

.btn-danger:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

select {
  padding: 0.25rem;
  border: 1px solid #e2e8f0;
  border-radius: 4px;
}

select:disabled {
  background: #f1f5f9;
  cursor: not-allowed;
}
</style>