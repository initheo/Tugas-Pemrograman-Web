<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <Sidebar @logout="handleLogout" />
    
    <!-- Main Content -->
    <div class="lg:ml-64 transition-all duration-300">
      <!-- Top Header -->
      <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
              <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
              <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-bell"></i>
              </button>
            </div>
          </div>
        </div>
      </header>
      
      <!-- Main Content Area -->
      <main class="flex-1">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
          <!-- Role-based Dashboard -->
          <AdminDashboard v-if="authService.isAdmin()" />
          <UserDashboard v-else-if="authService.isUser()" />
          
          <!-- Fallback content -->
          <div v-else class="text-center py-12">
            <div class="text-gray-500">
              <p class="text-lg">Selamat datang!</p>
              <p class="mt-2">Silakan login terlebih dahulu untuk mengakses dashboard.</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'
import { authService } from '../services/authService'
import Sidebar from '../components/Sidebar.vue'
import AdminDashboard from '../components/AdminDashboard.vue'
import UserDashboard from '../components/UserDashboard.vue'

const router = useRouter()
const authStore = useAuthStore()

const handleLogout = async () => {
  try {
    await authStore.logout()
    router.push('/')
  } catch (error) {
    console.error('Logout error:', error)
  }
}
</script>
