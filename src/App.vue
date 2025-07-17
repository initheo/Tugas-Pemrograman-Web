<template>
  <div id="app">
    <!-- Show login page without layout -->
    <div v-if="$route.name === 'Login'">
      <router-view />
    </div>
    
    <!-- Show pages with sidebar (no header) -->
    <div v-else-if="isPageRoute" class="min-h-screen bg-gray-50">
      <router-view />
    </div>
    
    <!-- Show main layout with unified header for views -->
    <div v-else class="min-h-screen bg-gray-50">
      <!-- Use unified Header component -->
      <Header />
      
      <!-- Main Content -->
      <main>
        <router-view />
      </main>
    </div>
    
    <!-- Debug component untuk development -->
    <AuthDebug v-if="isDevelopment" />
  </div>
</template>

<script>
import { onMounted, computed } from 'vue'
import { useAuthStore } from './stores/authStore'
import { useRoute } from 'vue-router'
import Header from './components/Header.vue' 

export default {
  name: 'App',
  components: {
    Header
  },
  setup() {
    const authStore = useAuthStore()
    const route = useRoute()

    const isDevelopment = computed(() => {
      return import.meta.env.DEV
    })

    // Check if current route is a page route (should use sidebar instead of header)
    const isPageRoute = computed(() => {
      const pageRoutes = [
        'Dashboard',
        'Customers', 
        'Branches',
        'Vouchers',
        'Transactions',
        'ServicesManagement',
        'Profile',
        'Settings'
      ]
      return pageRoutes.includes(route.name)
    })

    onMounted(() => {
      // Initialize auth state from localStorage
      authStore.initializeAuth()
    })

    return {
      authStore,
      isDevelopment,
      isPageRoute
    }
  }
}
</script>