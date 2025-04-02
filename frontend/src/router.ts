  import { createRouter, createWebHistory } from 'vue-router'
import CarFestival from './components/CarFestival.vue'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import AdminPanel from './components/admin/Dashboard.vue'
import EventDetails from './components/EventDetails.vue'
import { useAuthStore } from './stores/auth'

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
      path: '/admin',
      component: AdminPanel,
      meta: { requiresAdmin: true }
    },
    {
      path: '/event/:id',
      component: EventDetails,
      props: true
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