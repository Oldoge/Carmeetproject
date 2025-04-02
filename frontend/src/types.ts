export interface User {
  id: string
  email: string
  role: 'admin' | 'organizer' | 'user'
  createdAt: Date
  lastLogin: Date | null
  status: 'active' | 'inactive' | 'suspended'
  name: string
  organization?: string
}

export interface Festival {
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

export interface ActivityLog {
  id: string
  userId: string
  action: string
  details: string
  timestamp: Date
  ipAddress: string
}

export interface UserFilters {
  role?: 'admin' | 'organizer' | 'user'
  status?: 'active' | 'inactive' | 'suspended'
  search?: string
  sortBy?: 'name' | 'email' | 'createdAt' | 'lastLogin'
  sortOrder?: 'asc' | 'desc'
}