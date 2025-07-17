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
              <h1 class="text-xl font-semibold text-gray-900">
                {{ authService.isAdmin() ? 'Vouchers Management' : 'My Vouchers' }}
              </h1>
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
          <!-- Admin View -->
          <div v-if="authService.isAdmin()">
            <div class="flex items-center justify-between mb-6">
              <h1 class="text-2xl font-semibold">Vouchers Management</h1>
              <button
                @click="openCreateForm"
                class="flex items-center gap-2 px-4 py-2 text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                  />
                </svg>
                Add Voucher
              </button>
            </div>
          </div>

          <!-- User View -->
          <div v-else>
            <div class="mb-6">
              <h1 class="text-2xl font-semibold">Voucher Tersedia</h1>
              <p class="text-gray-600 mt-2">Dapatkan diskon menarik untuk transaksi laundry Anda</p>
            </div>
          </div>

          <div class="bg-white rounded-lg shadow">
            <div class="p-6">
              <!-- Search (for admin) -->
              <div v-if="authService.isAdmin()" class="flex items-center justify-between mb-4">
                <div class="relative">
                  <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search vouchers..."
                    class="py-2 pl-10 pr-4 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                  <svg
                    class="w-5 h-5 text-gray-400 absolute left-3 top-2.5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                  </svg>
                </div>
                <select
                  v-model="itemsPerPage"
                  class="px-3 py-2 border rounded-lg"
                >
                  <option :value="5">5 per page</option>
                  <option :value="10">10 per page</option>
                  <option :value="20">20 per page</option>
                </select>
              </div>

              <!-- Admin Table View -->
              <div v-if="authService.isAdmin()" class="overflow-x-auto">
                <table class="w-full">
                  <thead>
                    <tr class="text-sm text-left text-gray-600">
                      <th class="pb-4">Name</th>
                      <th class="pb-4">Discount Rate</th>
                      <th class="pb-4">Valid From</th>
                      <th class="pb-4">Valid Until</th>
                      <th class="pb-4">Status</th>
                      <th class="pb-4">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-if="voucherStore.loading"
                      class="animate-pulse"
                    >
                      <td colspan="6" class="py-4 text-center">Loading...</td>
                    </tr>
                    <tr
                      v-else-if="voucherStore.vouchers.length === 0"
                      class="border-t"
                    >
                      <td colspan="6" class="py-4 text-center text-gray-500">No vouchers found</td>
                    </tr>
                    <tr
                      v-for="voucher in paginatedVouchers"
                      :key="voucher.id"
                      class="border-t hover:bg-gray-50 transition-colors"
                    >
                      <td class="py-4">{{ voucher.name }}</td>
                      <td>{{ voucher.discount_percentage }}%</td>
                      <td>{{ formatDate(voucher.valid_from) }}</td>
                      <td>{{ formatDate(voucher.valid_until) }}</td>
                      <td>
                        <span :class="getStatusClass(voucher)" class="px-2 py-1 text-xs font-medium rounded-full">
                          {{ getVoucherStatus(voucher) }}
                        </span>
                      </td>
                      <td class="flex items-center gap-2 py-4">
                        <button
                          @click="openEditForm(voucher)"
                          class="p-2 text-blue-600 transition-colors duration-200 rounded-lg hover:bg-blue-100"
                          title="Edit Voucher"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                          </svg>
                        </button>
                        <button
                          @click="handleDelete(voucher)"
                          class="p-2 text-red-600 transition-colors duration-200 rounded-lg hover:bg-red-100"
                          title="Delete Voucher"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- User Card View -->
              <div v-else-if="authService.isUser()" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-if="voucherStore.loading" class="col-span-full text-center py-8">
                  <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                  <p class="mt-2 text-gray-600">Loading vouchers...</p>
                </div>
                
                <div v-else-if="voucherStore.error" class="col-span-full text-center py-8">
                  <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="text-red-600 mb-2">{{ voucherStore.error }}</p>
                  <button 
                    @click="loadVouchers()" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                  >
                    Coba Lagi
                  </button>
                </div>
                
                <div v-else-if="activeVouchers.length === 0 && voucherStore.vouchers.length === 0" class="col-span-full text-center py-8">
                  <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                  </svg>
                  <p class="text-gray-600">Tidak ada voucher yang tersedia saat ini</p>
                </div>
                
                <div v-else-if="activeVouchers.length === 0 && voucherStore.vouchers.length > 0" class="col-span-full text-center py-8">
                  <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <p class="text-gray-600">Semua voucher sedang tidak aktif</p>
                  <p class="text-sm text-gray-500 mt-1">Total voucher tersedia: {{ voucherStore.vouchers.length }}</p>
                </div>

                <div
                  v-for="voucher in activeVouchers"
                  :key="voucher.id"
                  class="bg-gradient-to-br from-blue-50 to-indigo-100 border border-blue-200 rounded-lg p-6 hover:shadow-lg transition-shadow"
                >
                  <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                      <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ voucher.name }}</h3>
                      <div class="flex items-center mb-2">
                        <span class="text-3xl font-bold text-blue-600">{{ voucher.discount_percentage }}%</span>
                        <span class="text-gray-600 ml-2">OFF</span>
                      </div>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                      Aktif
                    </div>
                  </div>
                  
                  <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      Berlaku hingga: {{ formatDate(voucher.valid_until) }}
                    </div>
                    <div class="flex items-center">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                      Dapat digunakan untuk transaksi
                    </div>
                  </div>

                  <div class="mt-4 pt-4 border-t border-blue-200">
                    <p class="text-xs text-gray-500">
                      Kode voucher akan otomatis diterapkan saat melakukan transaksi
                    </p>
                  </div>
                </div>
              </div>

              <!-- Pagination (Admin only) -->
              <div v-if="authService.isAdmin()" class="flex items-center justify-between mt-4">
                <div class="text-sm text-gray-600">
                  Showing {{ ((currentPage - 1) * itemsPerPage) + 1 }} to
                  {{ Math.min(currentPage * itemsPerPage, filteredVouchers.length) }} of
                  {{ filteredVouchers.length }} entries
                </div>
                <div class="flex space-x-2">
                  <button
                    :disabled="currentPage === 1"
                    @click="currentPage--"
                    class="px-3 py-1 border rounded-lg disabled:opacity-50"
                    :class="{ 'hover:bg-gray-100': currentPage !== 1 }"
                  >
                    Previous
                  </button>
                  <button
                    :disabled="currentPage === totalPages"
                    @click="currentPage++"
                    class="px-3 py-1 border rounded-lg disabled:opacity-50"
                    :class="{ 'hover:bg-gray-100': currentPage !== totalPages }"
                  >
                    Next
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Voucher Form Modal (Admin only) -->
          <div
            v-if="authService.isAdmin() && showForm"
            class="fixed inset-0 flex items-center justify-center bg-black/50"
          >
            <div class="w-full max-w-md p-6 bg-white rounded-lg">
              <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">
                  {{ formMode === 'edit' ? 'Edit' : 'Add New' }} Voucher
                </h2>
                <button @click="closeForm" class="text-gray-500 hover:text-gray-700">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <VoucherForm
                :voucher="selectedVoucher"
                :mode="formMode"
                @submit="closeForm"
              />
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'
import { useVoucherStore } from '../stores/voucherStore'
import { authService } from '../services/authService'
import api from '../services/api'
import VoucherForm from '../components/VoucherForm.vue'
import Sidebar from '../components/Sidebar.vue'

export default {
  name: 'VouchersPage',
  components: {
    VoucherForm,
    Sidebar
  },
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    const voucherStore = useVoucherStore()
    
    // Reactive data
    const showForm = ref(false)
    const selectedVoucher = ref(null)
    const formMode = ref('create')
    const searchQuery = ref('')
    const itemsPerPage = ref(10)
    const currentPage = ref(1)

    // Computed properties
    const filteredVouchers = computed(() => {
      if (!searchQuery.value) return voucherStore.vouchers

      return voucherStore.vouchers.filter(voucher =>
        voucher.name.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    })

    // Active vouchers for user view
    const activeVouchers = computed(() => {
      const now = new Date()
      return voucherStore.vouchers.filter(voucher => {
        const validUntil = new Date(voucher.valid_until)
        const validFrom = new Date(voucher.valid_from)
        return validFrom <= now && validUntil >= now
      })
    })

    const paginatedVouchers = computed(() => {
      const vouchers = filteredVouchers.value || []
      const start = (currentPage.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return vouchers.slice(start, end)
    })

    const totalPages = computed(() => {
      const total = filteredVouchers.value?.length || 0
      return Math.ceil(total / itemsPerPage.value)
    })

    // Methods
    const openCreateForm = () => {
      selectedVoucher.value = null
      formMode.value = 'create'
      showForm.value = true
    }

    const openEditForm = (voucher) => {
      selectedVoucher.value = voucher
      formMode.value = 'edit'
      showForm.value = true
    }

    const closeForm = () => {
      showForm.value = false
      selectedVoucher.value = null
      formMode.value = 'create'
    }

    const handleDelete = async (voucher) => {
      if (confirm(`Are you sure you want to delete voucher "${voucher.name}"?`)) {
        try {
          await voucherStore.deleteVoucher(voucher.id)
          alert('Voucher deleted successfully!')
        } catch (error) {
          console.error('Error deleting voucher:', error)
          alert('Error deleting voucher: ' + error.message)
        }
      }
    }

    const handleLogout = async () => {
      try {
        await authStore.logout()
        router.push('/')
      } catch (error) {
        console.error('Logout error:', error)
      }
    }

    // Utility functions
    const formatDate = (date) => {
      if (!date) return 'N/A'
      try {
        return new Date(date).toLocaleDateString('id-ID', {
          year: 'numeric',
          month: 'short',
          day: 'numeric'
        })
      } catch {
        return 'N/A'
      }
    }

    const getVoucherStatus = (voucher) => {
      const now = new Date()
      const validFrom = new Date(voucher.valid_from)
      const validUntil = new Date(voucher.valid_until)
      
      if (now < validFrom) return 'Belum Aktif'
      if (now > validUntil) return 'Kadaluarsa'
      return 'Aktif'
    }

    const getStatusClass = (voucher) => {
      const status = getVoucherStatus(voucher)
      if (status === 'Aktif') return 'bg-green-100 text-green-800'
      if (status === 'Kadaluarsa') return 'bg-red-100 text-red-800'
      return 'bg-yellow-100 text-yellow-800'
    }

    const loadVouchers = async () => {
      console.log('Loading vouchers for user role:', authService.isUser() ? 'user' : 'admin')
      
      // Set loading state
      voucherStore.loading = true
      voucherStore.error = null
      
      try {
        if (authService.isUser()) {
          // For users, load available vouchers from the user vouchers endpoint
          console.log('Fetching vouchers from /user/vouchers endpoint for user...')
          const response = await api.get('/user/vouchers')
          console.log('User vouchers response:', response.data)
          
          // Handle different response structures
          let vouchersData = []
          if (response.data && Array.isArray(response.data.data)) {
            vouchersData = response.data.data
          } else if (response.data && Array.isArray(response.data)) {
            vouchersData = response.data
          } else if (Array.isArray(response.data)) {
            vouchersData = response.data
          }
          
          voucherStore.vouchers = vouchersData
          console.log('Vouchers loaded for user:', vouchersData.length, vouchersData)
        } else {
          // For admin, load all vouchers
          console.log('Fetching vouchers for admin...')
          await voucherStore.fetchVouchers()
        }
        
        voucherStore.loading = false
      } catch (error) {
        voucherStore.loading = false
        voucherStore.error = error.message
        console.error('Error loading vouchers:', error)
        console.error('Full error details:', {
          message: error.message,
          status: error.response?.status,
          statusText: error.response?.statusText,
          data: error.response?.data,
          headers: error.response?.headers
        })
        
        // Show user-friendly error message
        alert('Gagal memuat data voucher. Silakan coba lagi atau hubungi administrator.')
        
        // Set empty array instead of mock data to avoid confusion
        voucherStore.vouchers = []
      }
    }

    // Load vouchers on component mount
    onMounted(() => {
      loadVouchers()
    })

    return {
      authService,
      voucherStore,
      showForm,
      selectedVoucher,
      formMode,
      searchQuery,
      itemsPerPage,
      currentPage,
      filteredVouchers,
      activeVouchers,
      paginatedVouchers,
      totalPages,
      openCreateForm,
      openEditForm,
      closeForm,
      handleDelete,
      formatDate,
      getVoucherStatus,
      getStatusClass,
      loadVouchers,
      handleLogout
    }
  }
}
</script>