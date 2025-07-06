<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Vouchers</h1>
      <button
        @click="openCreateForm"
        class="flex items-center gap-2 px-4 py-2 text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
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

    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <!-- Search and Items per page -->
        <div class="flex items-center justify-between mb-4">
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

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-sm text-left text-gray-600">
                <th class="pb-4">Name</th>
                <th class="pb-4">Discount Rate</th>
                <th class="pb-4">Valid From</th>
                <th class="pb-4">Valid Until</th>
                <th class="pb-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-if="voucherStore.loading"
                class="animate-pulse"
              >
                <td colspan="5" class="py-4 text-center">Loading...</td>
              </tr>
              <tr
                v-else-if="voucherStore.vouchers.length === 0"
                class="border-t"
              >
                <td colspan="5" class="py-4 text-center text-gray-500">No vouchers found</td>
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

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-4">
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

    <!-- Voucher Form Modal -->
    <div
      v-if="showForm"
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
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useVoucherStore } from '../stores/voucherStore'
import VoucherForm from '../components/VoucherForm.vue'

export default {
  name: 'VouchersPage',
  components: {
    VoucherForm
  },
  setup() {
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
      const vouchers = voucherStore.vouchers || []
      if (!searchQuery.value) return vouchers
      
      return vouchers.filter(voucher =>
        voucher.name?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        voucher.discount_percentage?.toString().includes(searchQuery.value.toLowerCase())
      )
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

    const loadVouchers = async () => {
      try {
        await voucherStore.fetchVouchers()
      } catch (error) {
        console.error('Error loading vouchers:', error)
        // Set mock data if API fails
        voucherStore.vouchers = [
          {
            id: 1,
            name: 'New Year Discount',
            discount_percentage: 20,
            valid_from: '2024-01-01',
            valid_until: '2024-01-31'
          },
          {
            id: 2,
            name: 'Summer Sale',
            discount_percentage: 15,
            valid_from: '2024-06-01',
            valid_until: '2024-08-31'
          }
        ]
        console.log('Using mock data for vouchers')
      }
    }

    // Load vouchers on component mount
    onMounted(() => {
      loadVouchers()
    })

    return {
      voucherStore,
      showForm,
      selectedVoucher,
      formMode,
      searchQuery,
      itemsPerPage,
      currentPage,
      filteredVouchers,
      paginatedVouchers,
      totalPages,
      openCreateForm,
      openEditForm,
      closeForm,
      handleDelete,
      formatDate,
      loadVouchers
    }
  }
}
</script>