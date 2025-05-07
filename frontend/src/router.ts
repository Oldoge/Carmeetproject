  import { createRouter, createWebHistory } from 'vue-router'
import CarFestival from './components/CarFestival.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'

import EventDetails from './components/EventDetails.vue'
import { useAuthStore } from './stores/auth'
import AdminPanel2 from './components/admin/dash1.vue';


const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: CarFestival
    },
    {
      path: '/login',
      component: Login
    },
    {
      path: '/register',
      component: Register
    },
    
    {
      path: '/event/:id',
      component: EventDetails,
      props: true
    },
    {
      path: '/adminDASH',
      name: 'admindashboard',
      component: AdminPanel2,
    }
  ]
})

// Navigation guard for admin routes
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  
  if (to.meta.requiresAdmin && !authStore.isAdmin) {
    next('/login')
  } else {
    next()
  }
})

export default router