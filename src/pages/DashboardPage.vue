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
                :key="customer.name"
                class="border-t"
              >
                <td class="py-4">{{ customer.name }}</td>
                <td>Rp {{ customer.totalAmount.toLocaleString() }}</td>
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
                :key="branch.name"
                class="border-t"
              >
                <td class="py-4">{{ branch.name }}</td>
                <td>Rp {{ branch.totalRevenue.toLocaleString() }}</td>
                <td>{{ branch.totalTransactions }}</td>
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
import { useCustomerStore } from '../stores/customerStore'
import { useBranchStore } from '../stores/branchStore'
import { useVoucherStore } from '../stores/voucherStore'
import { useAuthStore } from '../stores/authStore'

export default {
  name: 'DashboardPage',
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const customerStore = useCustomerStore()
    const branchStore = useBranchStore()
    const voucherStore = useVoucherStore()
    
    const loading = ref(false)
    const error = ref(null)

    // Mock data for best customers and branches
    const topCustomers = ref([
      { name: 'John Doe', totalAmount: 2500000, totalTransactions: 15 },
      { name: 'Jane Smith', totalAmount: 1800000, totalTransactions: 12 },
      { name: 'Bob Johnson', totalAmount: 1200000, totalTransactions: 8 }
    ])

    const topBranches = ref([
      { name: 'Branch Central', totalRevenue: 15000000, totalTransactions: 120 },
      { name: 'Branch East', totalRevenue: 12000000, totalTransactions: 95 },
      { name: 'Branch West', totalRevenue: 9000000, totalTransactions: 78 }
    ])

    // Computed stats
    const stats = computed(() => [
      {
        label: 'Total Customers',
        value: customerStore.totalCustomers,
        change: '+12%',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
      },
      {
        label: 'Total Branches',
        value: branchStore.totalBranches,
        change: '+5%',
        icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
      },
      {
        label: 'Active Vouchers',
        value: voucherStore.activeVouchers.length,
        change: '+8%',
        icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'
      }
    ])

    // Load dashboard data
    const loadDashboardData = async () => {
      loading.value = true
      error.value = null

      try {
        // Load data dengan error handling untuk setiap store
        const promises = []
        
        // Hanya load jika store tersedia
        if (customerStore?.fetchCustomers) {
          promises.push(customerStore.fetchCustomers().catch(err => {
            console.warn('Failed to load customers:', err)
          }))
        }
        
        if (branchStore?.fetchBranches) {
          promises.push(branchStore.fetchBranches().catch(err => {
            console.warn('Failed to load branches:', err)
          }))
        }
        
        if (voucherStore?.fetchVouchers) {
          promises.push(voucherStore.fetchVouchers().catch(err => {
            console.warn('Failed to load vouchers:', err)
          }))
        }
        
        await Promise.allSettled(promises)
        
      } catch (err) {
        error.value = 'Failed to load dashboard data'
        console.error('Dashboard error:', err)
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
      setTimeout(() => {
        loadDashboardData()
      }, 100)
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