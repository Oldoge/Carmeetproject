import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import type { User, UserProfile } from '../types'
import { useActivityStore } from './activity'

interface LoginCredentials {
  email: string
  password: string
}

interface RegisterData extends LoginCredentials {
  name: string
  role: 'organizer' | 'user'
  organization?: string
}

const defaultProfile: UserProfile = {
  nickname: 'CarEnthusiast',
  affiliation: 'Car Enthusiast Community',
  introduction: 'Welcome to my profile! I love everything about cars.',
  interests: ['Cars', 'Automotive Events'],
  eventsAttended: []
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const activityStore = useActivityStore()
  
  // Mock users database
  const users = ref<User[]>([
    {
      id: '1',
      email: 'admin@motormania.com',
      role: 'admin',
      name: 'Admin User',
      createdAt: new Date('2024-01-01'),
      lastLogin: new Date(),
      status: 'active',
      profile: {
        nickname: 'AdminPro',
        fullName: 'Admin User',
        affiliation: 'MotorMania Administration',
        introduction: 'Platform administrator and car enthusiast.',
        interests: ['Event Management', 'Community Building'],
        eventsAttended: []
      }
    }
  ])

  const isAuthenticated = computed(() => user.value !== null)
  const isAdmin = computed(() => user.value?.role === 'admin')
  const isOrganizer = computed(() => user.value?.role === 'organizer')

  const login = async ({ email, password }: LoginCredentials): Promise<boolean> => {
    const foundUser = users.value.find(u => u.email === email)
    
    if (foundUser && foundUser.status === 'active') {
      user.value = foundUser
      foundUser.lastLogin = new Date()
      
      activityStore.logActivity({
        userId: foundUser.id,
        action: 'LOGIN',
        details: `User logged in: ${email}`
      })
      
      return true
    }
    
    throw new Error('Invalid credentials or account is inactive')
  }

  const register = async (data: RegisterData): Promise<boolean> => {
    if (users.value.some(u => u.email === data.email)) {
      throw new Error('Email already exists')
    }

    const newUser: User = {
      id: crypto.randomUUID(),
      email: data.email,
      role: data.role,
      name: data.name,
      organization: data.organization,
      createdAt: new Date(),
      lastLogin: null,
      status: 'active',
      profile: { ...defaultProfile }
    }

    users.value.push(newUser)
    
    activityStore.logActivity({
      userId: newUser.id,
      action: 'REGISTER',
      details: `New user registered: ${data.email} (${data.role})`
    })

    return true
  }

  const logout = () => {
    if (user.value) {
      activityStore.logActivity({
        userId: user.value.id,
        action: 'LOGOUT',
        details: `User logged out: ${user.value.email}`
      })
    }
    user.value = null
  }

  const updateProfile = async (userId: string, profile: UserProfile) => {
    const userIndex = users.value.findIndex(u => u.id === userId)
    if (userIndex === -1) throw new Error('User not found')
    
    users.value[userIndex].profile = profile
    
    activityStore.logActivity({
      userId,
      action: 'UPDATE_PROFILE',
      details: `Updated profile for user: ${users.value[userIndex].email}`
    })
  }

  const updateUser = (userId: string, updates: Partial<User>) => {
    const userIndex = users.value.findIndex(u => u.id === userId)
    if (userIndex === -1) throw new Error('User not found')

    users.value[userIndex] = { ...users.value[userIndex], ...updates }
    
    activityStore.logActivity({
      userId: user.value?.id || '',
      action: 'UPDATE_USER',
      details: `Updated user: ${users.value[userIndex].email}`
    })
  }

  const deleteUser = (userId: string) => {
    const userIndex = users.value.findIndex(u => u.id === userId)
    if (userIndex === -1) throw new Error('User not found')

    const deletedUser = users.value[userIndex]
    users.value = users.value.filter(u => u.id !== userId)
    
    activityStore.logActivity({
      userId: user.value?.id || '',
      action: 'DELETE_USER',
      details: `Deleted user: ${deletedUser.email}`
    })
  }

  const getAllUsers = (filters?: UserFilters) => {
    let filteredUsers = [...users.value]

    if (filters) {
      if (filters.role) {
        filteredUsers = filteredUsers.filter(u => u.role === filters.role)
      }
      if (filters.status) {
        filteredUsers = filteredUsers.filter(u => u.status === filters.status)
      }
      if (filters.search) {
        const search = filters.search.toLowerCase()
        filteredUsers = filteredUsers.filter(u => 
          u.name.toLowerCase().includes(search) ||
          u.email.toLowerCase().includes(search) ||
          u.organization?.toLowerCase().includes(search)
        )
      }
      if (filters.sortBy) {
        filteredUsers.sort((a, b) => {
          const aValue = a[filters.sortBy!]
          const bValue = b[filters.sortBy!]
          const order = filters.sortOrder === 'desc' ? -1 : 1
          
          return aValue < bValue ? -order : order
        })
      }
    }

    return filteredUsers
  }

  return {
    user,
    users,
    isAuthenticated,
    isAdmin,
    isOrganizer,
    login,
    register,
    logout,
    updateUser,
    deleteUser,
    getAllUsers,
    updateProfile
  }
})