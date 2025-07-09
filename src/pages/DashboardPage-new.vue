<template>
  <div class="p-6">
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
</template>

<script setup>
import { useAuthStore } from '../stores/authStore'
import { authService } from '../services/authService'
import AdminDashboard from '../components/AdminDashboard.vue'
import UserDashboard from '../components/UserDashboard.vue'

const authStore = useAuthStore()
</script>
