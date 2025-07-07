<template>
  <div class="p-6">
    <div v-if="error" class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
      {{ error }}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <div
        v-for="stat in stats"
        :key="stat.label"
        class="bg-white rounded-lg shadow p-6"
      >
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-600">{{ stat.label }}</p>
            <p class="text-2xl font-semibold mt-1">
              <span v-if="loading">Loading...</span>
              <span v-else>{{ stat.value }}</span>
            </p>
          </div>
          <div class="p-3 bg-primary/10 rounded-full">
            <svg
              class="w-6 h-6 text-primary"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                :d="stat.icon"
              />
            </svg>
          </div>
        </div>
        <p :class="[
          'text-sm mt-2',
          stat.change.startsWith('+') ? 'text-green-600' : 'text-red-600'
        ]">
          {{ stat.change }} from last week
        </p>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">The Best Customer</h2>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-left text-sm text-gray-600">
                <th class="pb-4">Customer</th>
                <th class="pb-4">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="2" class="py-4 text-center">Loading...</td>
              </tr>
              <tr v-else-if="topCustomers.length === 0">
                <td colspan="2" class="py-4 text-center text-gray-500">No data available</td>
              </tr>
              <tr
                v-else
                v-for="customer in topCustomers"
                :key="customer.name || customer.id"
                class="border-t"
              >
                <td class="py-4">{{ customer.name }}</td>
                <td>Rp {{ Number(customer.totalAmount || 0).toLocaleString() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">The Best Branch Shop</h2>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-left text-sm text-gray-600">
                <th class="pb-4">Name</th>
                <th class="pb-4">Total Revenue</th>
                <th class="pb-4">Total Transaction</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="3" class="py-4 text-center">Loading...</td>
              </tr>
              <tr v-else-if="topBranches.length === 0">
                <td colspan="3" class="py-4 text-center text-gray-500">No data available</td>
              </tr>
              <tr
                v-else
                v-for="branch in topBranches"
                :key="branch.name || branch.id"
                class="border-t"
              >
                <td class="py-4">{{ branch.name }}</td>
                <td>Rp {{ Number(branch.totalRevenue || 0).toLocaleString() }}</td>
                <td>{{ branch.totalTransactions || 0 }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'
import { dashboardService } from '../services/dashboardService'

export default {
  name: 'DashboardPage',
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    
    const loading = ref(false)
    const error = ref(null)
    
    // Dashboard data from API
    const dashboardData = ref(null)
    const topCustomers = ref([])
    const topBranches = ref([])

    // Simple computed stats for debugging
    const stats = computed(() => {
      console.log('Computing stats, dashboardData:', dashboardData.value)
      
      if (!dashboardData.value) {
        console.log('No dashboard data, returning defaults')
        return [
          {
            label: 'Total Customers',
            value: 0,
            change: '+0%',
            icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 616 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
          },
          {
            label: 'Total Branches',
            value: 0,
            change: '+0%',
            icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
          },
          {
            label: 'Active Vouchers',
            value: 0,
            change: '+0%',
            icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 713 12V7a4 4 0 714-4z'
          }
        ]
      }
      
      // Use direct response structure
      const data = dashboardData.value
      console.log('Using dashboard data:', data)
      
      return [
        {
          label: 'Total Customers',
          value: data.total_customers || 0,
          change: '+12%',
          icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 919.288 0M15 7a3 3 0 11-6 0 3 3 0 616 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
        },
        {
          label: 'Total Branches',
          value: data.total_branches || 0,
          change: '+5%',
          icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
        },
        {
          label: 'Active Vouchers',
          value: data.active_vouchers || 0,
          change: '+8%',
          icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 713 12V7a4 4 0 714-4z'
        }
      ]
    })

    // Load dashboard data
    const loadDashboardData = async () => {
      loading.value = true
      error.value = null

      try {
        console.log('Loading dashboard data from API...')
        const response = await dashboardService.getDashboardData()
        console.log('Dashboard API response:', response)
        
        if (response) {
          // Response structure dari endpoint yang Anda buat:
          // { total_customers, total_branches, active_vouchers, best_customers, best_branches }
          const apiData = response
          console.log('API Data received:', apiData)
          
          // Store data untuk computed stats (langsung gunakan response)
          dashboardData.value = apiData
          
          // Update customers data
          if (apiData.best_customers && Array.isArray(apiData.best_customers)) {
            topCustomers.value = apiData.best_customers.map(customer => ({
              id: customer.id,
              name: customer.name || 'Unknown',
              totalAmount: Number(customer.transactions_sum_total_amount) || 0,
              totalTransactions: 0 // Tidak ada data transactions count dari withSum
            }))
          }
          
          // Update branches data
          if (apiData.best_branches && Array.isArray(apiData.best_branches)) {
            topBranches.value = apiData.best_branches.map(branch => ({
              id: branch.id,
              name: branch.name || 'Unknown',
              totalRevenue: Number(branch.transactions_sum_total_amount) || 0,
              totalTransactions: 0 // Tidak ada data transactions count dari withSum
            }))
          }
        }
        
      } catch (err) {
        error.value = 'Failed to load dashboard data: ' + err.message
        console.error('Dashboard error:', err)
        
        // Reset to empty arrays on error
        topCustomers.value = []
        topBranches.value = []
        dashboardData.value = null
      } finally {
        loading.value = false
      }
    }

    onMounted(() => {
      console.log('DashboardPage: Mounted, checking auth state...')
      console.log('DashboardPage: Auth state:', {
        isAuthenticated: authStore.isAuthenticated,
        user: authStore.currentUser
      })
      
      // Verify authentication
      if (!authStore.isAuthenticated) {
        console.log('DashboardPage: Not authenticated, redirecting to login')
        router.push('/login')
        return
      }
      
      // Load dashboard data setelah mount
      loadDashboardData()
    })

    return {
      stats,
      topCustomers,
      topBranches,
      loading,
      error
    }
  }
}
</script>