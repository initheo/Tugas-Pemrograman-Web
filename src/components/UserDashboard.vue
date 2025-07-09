<template>
  <div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-900">Dashboard User</h1>
      <div class="text-sm text-gray-500">
        Selamat datang, {{ authStore.user?.name }}
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
            <p class="text-2xl font-bold text-gray-900">{{ dashboardStats?.stats?.totalTransactions || 0 }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ formatCurrency(dashboardStats?.stats?.totalSpent || 0) }}</p>
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
            <p class="text-sm font-medium text-gray-600">Total Hemat</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ formatCurrency(dashboardStats?.stats?.totalSavings || 0) }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ formatCurrency(dashboardStats?.stats?.monthlySpending || 0) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts and Recent Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Spending Chart -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Pengeluaran (6 Bulan Terakhir)</h3>
        <div class="h-64 flex items-center justify-center">
          <div v-if="dashboardStats?.spendingByMonth?.length > 0" class="w-full">
            <canvas ref="spendingChart" class="w-full h-full"></canvas>
          </div>
          <div v-else class="text-gray-500">Belum ada data transaksi</div>
        </div>
      </div>

      <!-- Recent Transactions -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terbaru</h3>
        <div class="space-y-3">
          <div v-if="dashboardStats?.recentTransactions?.length > 0">
            <div v-for="transaction in dashboardStats.recentTransactions" :key="transaction.id" 
                 class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
              <div>
                <p class="font-medium text-gray-900">{{ transaction.customer?.name }}</p>
                <p class="text-sm text-gray-600">{{ formatDate(transaction.transaction_date) }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold text-gray-900">Rp {{ formatCurrency(transaction.total_amount) }}</p>
                <span :class="getStatusBadgeClass(transaction.status_payment)" 
                      class="inline-flex px-2 py-1 text-xs font-medium rounded-full">
                  {{ getStatusText(transaction.status_payment) }}
                </span>
              </div>
            </div>
          </div>
          <div v-else class="text-gray-500 text-center py-8">
            Belum ada transaksi
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { useAuthStore } from '../stores/authStore'
import api from '../services/api'
import Chart from 'chart.js/auto'

const authStore = useAuthStore()
const dashboardStats = ref(null)
const spendingChart = ref(null)
const loading = ref(false)

// Fetch dashboard data
const fetchDashboardStats = async () => {
  try {
    loading.value = true
    const response = await api.get('/user/dashboard')
    dashboardStats.value = response.data.data
    
    // Create chart after data is loaded
    await nextTick()
    createSpendingChart()
  } catch (error) {
    console.error('Failed to fetch dashboard stats:', error)
  } finally {
    loading.value = false
  }
}

// Create spending chart
const createSpendingChart = () => {
  if (!dashboardStats.value?.spendingByMonth?.length || !spendingChart.value) return

  const ctx = spendingChart.value.getContext('2d')
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: dashboardStats.value.spendingByMonth.map(item => item.month),
      datasets: [{
        label: 'Pengeluaran (Rp)',
        data: dashboardStats.value.spendingByMonth.map(item => item.amount),
        borderColor: 'rgb(59, 130, 246)',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
            }
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Pengeluaran: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y)
            }
          }
        }
      }
    }
  })
}

// Utility functions
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID').format(amount)
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const getStatusBadgeClass = (status) => {
  const statusClasses = {
    'paid': 'bg-green-100 text-green-800',
    'unpaid': 'bg-red-100 text-red-800',
    'pending': 'bg-yellow-100 text-yellow-800',
    'expired': 'bg-gray-100 text-gray-800'
  }
  return statusClasses[status] || 'bg-gray-100 text-gray-800'
}

const getStatusText = (status) => {
  const statusTexts = {
    'paid': 'Lunas',
    'unpaid': 'Belum Bayar',
    'pending': 'Menunggu',
    'expired': 'Kadaluarsa'
  }
  return statusTexts[status] || status
}

onMounted(() => {
  fetchDashboardStats()
})
</script>
