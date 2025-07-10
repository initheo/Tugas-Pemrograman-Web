<template>
  <div id="app">
    <!-- Show login page without layout -->
    <div v-if="$route.name === 'Login'">
      <router-view />
    </div>
    
    <!-- Show main layout with unified header -->
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
import Header from './components/Header.vue' 

export default {
  name: 'App',
  components: {
    Header
  },
  setup() {
    const authStore = useAuthStore()

    const isDevelopment = computed(() => {
      return import.meta.env.DEV
    })

    onMounted(() => {
      // Initialize auth state from localStorage
      authStore.initializeAuth()
    })

    return {
      authStore,
      isDevelopment
    }
  }
}
</script>