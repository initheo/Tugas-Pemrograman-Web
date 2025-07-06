<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Customers</h1>
      <button
        @click="openModal()"
        class="flex items-center gap-2 px-4 py-2 mb-4 text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-6 h-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
          />
        </svg>
        Add New Customer
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
              placeholder="Search branches..."
              class="py-2 pl-10 pr-4 border rounded-lg focus:ring-2 focus:ring-primary/50"
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

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-sm font-medium text-left text-gray-600 border-b">
                <th
                  v-for="column in ['nama', 'nomorTelepon', 'alamatLengkap', 'tanggalLahir']"
                  :key="column"
                  class="pb-4 cursor-pointer select-none"
                  @click="toggleSort(column)"
                >
                  <div class="flex items-center space-x-1">
                    <span>{{ column === 'nama' ? 'Name' : column === 'nomorTelepon' ? 'Phone' : column === 'alamatLengkap' ? 'Address' : 'Birth Date' }}</span>
                    <svg
                      v-if="sortBy === column"
                      class="w-4 h-4"
                      :class="{ 'rotate-180': sortDesc }"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </div>
                </th>
                <th class="pb-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-if="customerStore.loading"
                class="animate-pulse"
              >
                <td colspan="4" class="py-4 text-center">Loading...</td>
              </tr>
              <tr
                v-else-if="paginatedCustomers.length === 0"
                class="border-t"
              >
                <td colspan="4" class="py-4 text-center text-gray-500">No data found.</td>
              </tr>
              <tr
                v-for="customer in paginatedCustomers"
                :key="customer.id"
                class="transition-colors border-t hover:bg-gray-50"
              >
                <td class="py-4">{{ customer.nama }}</td>
                <td>{{ customer.nomorTelepon }}</td>
                <td>{{ customer.alamatLengkap }}</td>
                <td>{{ customer.tanggalLahir }}</td>
                <td class="flex items-center gap-2 py-4 space-x-2">
                  <!-- Table Actions -->
                  <button
                    @click="openModal(customer)"
                    class="p-2 text-blue-600 transition-colors duration-200 rounded-lg hover:bg-blue-100"
                    title="Edit Branch"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>

                  <button
                    @click="handleDelete(customer)"
                    class="p-2 text-red-600 transition-colors duration-200 rounded-lg hover:bg-red-100"
                    title="Delete Branch"
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
            {{ Math.min(currentPage * itemsPerPage, filteredCustomers.length) }} of
            {{ filteredCustomers.length }} entries
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
     <!-- Modal Component -->
<div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true">
  <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <!-- Background overlay -->
    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
         @click="closeModal"></div>

    <!-- Modal panel -->
    <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <!-- Icon Customer -->
          <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
          </div>

          <!-- Form Content -->
          <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900" id="modal-title">
              {{ selectedCustomer ? 'Edit Customer' : 'Add New Customer' }}
            </h3>

            <form @submit.prevent="handleSubmit" class="space-y-4">
              <!-- Name Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  Name
                </label>
                <input
                  v-model="formData.nama"
                  type="text"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  placeholder="Enter customer name"
                />
              </div>

              <!-- Phone Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  Phone Number
                </label>
                <input
                  v-model="formData.nomorTelepon"
                  type="text"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  placeholder="Enter phone number"
                />
              </div>

              <!-- Address Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  Address
                </label>
                <textarea
                  v-model="formData.alamatLengkap"
                  rows="3"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  placeholder="Enter complete address"
                ></textarea>
              </div>

              <!-- Birth Date Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  Birth Date
                </label>
                <input
                  v-model="formData.tanggalLahir"
                  type="date"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                />
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
        <button
          type="submit"
          @click="handleSubmit"
          class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
        >
          {{ selectedCustomer ? 'Update' : 'Add' }}
        </button>
        <button
          type="button"
          @click="closeModal"
          class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useCustomerStore } from '../stores/customerStore'

export default {
  name: 'CustomersPage',
  setup() {
    const customerStore = useCustomerStore()
    
    // Reactive data
    const showModal = ref(false)
    const selectedCustomer = ref(null)
    const searchQuery = ref('')
    const itemsPerPage = ref(10)
    const sortBy = ref('nama')
    const sortDesc = ref(false)
    
    const formData = ref({
      nama: '',
      nomorTelepon: '',
      alamatLengkap: '',
      tanggalLahir: '',
      agama: ''
    })

    // Computed properties
    const filteredCustomers = computed(() => {
      if (!searchQuery.value) return customerStore.customers
      
      return customerStore.customers.filter(customer =>
        customer.nama?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        customer.nomorTelepon?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        customer.alamatLengkap?.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    })

    const sortedCustomers = computed(() => {
      const customers = [...filteredCustomers.value]
      
      return customers.sort((a, b) => {
        const aValue = a[sortBy.value] || ''
        const bValue = b[sortBy.value] || ''
        
        if (sortDesc.value) {
          return bValue.localeCompare(aValue)
        } else {
          return aValue.localeCompare(bValue)
        }
      })
    })

    const paginatedCustomers = computed(() => {
      const start = 0
      const end = itemsPerPage.value
      return sortedCustomers.value.slice(start, end)
    })

    // Methods
    const openModal = (customer = null) => {
      selectedCustomer.value = customer
      if (customer) {
        formData.value = { ...customer }
      } else {
        formData.value = {
          nama: '',
          nomorTelepon: '',
          alamatLengkap: '',
          tanggalLahir: '',
          agama: ''
        }
      }
      showModal.value = true
    }

    const closeModal = () => {
      showModal.value = false
      selectedCustomer.value = null
      formData.value = {
        nama: '',
        nomorTelepon: '',
        alamatLengkap: '',
        tanggalLahir: '',
        agama: ''
      }
    }

    const handleSubmit = async () => {
      try {
        if (selectedCustomer.value) {
          // Update existing customer
          await customerStore.updateCustomer(selectedCustomer.value.id, formData.value)
        } else {
          // Create new customer
          await customerStore.createCustomer(formData.value)
        }
        closeModal()
      } catch (error) {
        console.error('Error saving customer:', error)
        alert('Error saving customer: ' + error.message)
      }
    }

    const handleDelete = async (customer) => {
      if (confirm(`Are you sure you want to delete ${customer.nama}?`)) {
        try {
          await customerStore.deleteCustomer(customer.id)
        } catch (error) {
          console.error('Error deleting customer:', error)
          alert('Error deleting customer: ' + error.message)
        }
      }
    }

    const toggleSort = (column) => {
      if (sortBy.value === column) {
        sortDesc.value = !sortDesc.value
      } else {
        sortBy.value = column
        sortDesc.value = false
      }
    }

    const loadCustomers = async () => {
      try {
        await customerStore.fetchCustomers()
      } catch (error) {
        console.error('Error loading customers:', error)
      }
    }

    // Load customers on component mount
    onMounted(() => {
      loadCustomers()
    })

    return {
      customerStore,
      showModal,
      selectedCustomer,
      searchQuery,
      itemsPerPage,
      sortBy,
      sortDesc,
      formData,
      paginatedCustomers,
      openModal,
      closeModal,
      handleSubmit,
      handleDelete,
      toggleSort,
      loadCustomers
    }
  }
}
</script>