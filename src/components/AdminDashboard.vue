<template>
  <div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
      <div class="text-sm text-gray-500">
        Panel administrasi sistem
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
            <p class="text-2xl font-bold text-gray-900">{{ dashboardStats?.total_customers || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Cabang</p>
            <p class="text-2xl font-bold text-gray-900">{{ dashboardStats?.total_branches || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Voucher Aktif</p>
            <p class="text-2xl font-bold text-gray-900">{{ dashboardStats?.active_vouchers || 0 }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Best Performers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Best Customers -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top 5 Pelanggan Terbaik</h3>
        <div class="space-y-3">
          <div v-if="dashboardStats?.best_customers?.length > 0">
            <div v-for="(customer, index) in dashboardStats.best_customers" :key="customer.id" 
                 class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold mr-3">
                  {{ index + 1 }}
                </div>
                <div>
                  <p class="font-medium text-gray-900">{{ customer.name }}</p>
                  <p class="text-sm text-gray-600">{{ customer.email }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="font-semibold text-gray-900">Rp {{ formatCurrency(customer.transactions_sum_total_amount || 0) }}</p>
                <p class="text-sm text-gray-600">Total Belanja</p>
              </div>
            </div>
          </div>
          <div v-else class="text-gray-500 text-center py-8">
            Belum ada data pelanggan
          </div>
        </div>
      </div>

      <!-- Best Branches -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top 5 Cabang Terbaik</h3>
        <div class="space-y-3">
          <div v-if="dashboardStats?.best_branches?.length > 0">
            <div v-for="(branch, index) in dashboardStats.best_branches" :key="branch.id" 
                 class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div class="flex items-center">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-semibold mr-3">
                  {{ index + 1 }}
                </div>
                <div>
                  <p class="font-medium text-gray-900">{{ branch.name }}</p>
                  <p class="text-sm text-gray-600">{{ branch.address }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="font-semibold text-gray-900">Rp {{ formatCurrency(branch.transactions_sum_total_amount || 0) }}</p>
                <p class="text-sm text-gray-600">Total Penjualan</p>
              </div>
            </div>
          </div>
          <div v-else class="text-gray-500 text-center py-8">
            Belum ada data cabang
          </div>
        </div>
      </div>
    </div>
   
 
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const dashboardStats = ref(null)
const loading = ref(false)

// Fetch dashboard data
const fetchDashboardStats = async () => {
  try {
    loading.value = true
    const response = await api.get('/admin/dashboard')
    dashboardStats.value = response.data
  } catch (error) {
    console.error('Failed to fetch dashboard stats:', error)
  } finally {
    loading.value = false
  }
}

// Utility function
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

onMounted(() => {
  fetchDashboardStats()
})
</script>
