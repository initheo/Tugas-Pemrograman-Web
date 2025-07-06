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
  </div>
</template>

<script>
import { onMounted } from 'vue'
import { useAuthStore } from './stores/authStore'
import Header from './components/Header.vue'

export default {
  name: 'App',
  components: {
    Header
  },
  setup() {
    const authStore = useAuthStore()

    onMounted(() => {
      // Initialize auth state from localStorage
      authStore.initializeAuth()
    })

    return {
      authStore
    }
  }
}
</script>