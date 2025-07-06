<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Branch</h1>
      <button
        @click="openModal()"
        class="flex items-center gap-2 px-4 py-2 mb-4 text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add New Branch
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
                  v-for="column in ['namaCabang', 'kota', 'alamatLengkap']"
                  :key="column"
                  class="pb-4 cursor-pointer select-none"
                  @click="toggleSort(column)"
                >
                  <div class="flex items-center space-x-1">
                    <span>{{ column === 'namaCabang' ? 'Name' : column === 'kota' ? 'City' : 'Address' }}</span>
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
                v-if="branchStore.loading"
                class="animate-pulse"
              >
                <td colspan="4" class="py-4 text-center">Loading...</td>
              </tr>
              <tr
                v-else-if="paginatedBranches.length === 0"
                class="border-t"
              >
                <td colspan="4" class="py-4 text-center text-gray-500">No branches found</td>
              </tr>
              <tr
                v-for="branch in paginatedBranches"
                :key="branch.id"
                class="transition-colors border-t hover:bg-gray-50"
              >
                <td class="py-4">{{ branch.namaCabang }}</td>
                <td>{{ branch.kota }}</td>
                <td>{{ branch.alamatLengkap }}</td>
                <td class="flex items-center gap-2 py-4 space-x-2">
                  <!-- Table Actions -->
                  <button
                    @click="openModal(branch)"
                    class="p-2 text-blue-600 transition-colors duration-200 rounded-lg hover:bg-blue-100"
                    title="Edit Branch"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>

                  <button
                    @click="handleDelete(branch)"
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
            {{ Math.min(currentPage * itemsPerPage, filteredBranches.length) }} of
            {{ filteredBranches.length }} entries
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
          <!-- Icon -->
          <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>

          <!-- Form Content -->
          <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900" id="modal-title">
              {{ selectedBranch ? 'Edit Branch Office' : 'Add New Branch Office' }}
            </h3>

            <form @submit.prevent="handleSubmit" class="space-y-4">
              <!-- Branch Name Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  Branch Name
                </label>
                <input
                  v-model="formData.namaCabang"
                  type="text"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  placeholder="Enter branch name"
                />
              </div>

              <!-- City Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  City
                </label>
                <input
                  v-model="formData.kota"
                  type="text"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  placeholder="Enter city name"
                />
              </div>

              <!-- Address Field -->
              <div>
                <label class="block mb-2 text-sm font-bold text-gray-700">
                  Complete Address
                </label>
                <textarea
                  v-model="formData.alamatLengkap"
                  rows="3"
                  required
                  class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                  placeholder="Enter complete address"
                ></textarea>
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
          {{ selectedBranch ? 'Update Branch' : 'Add Branch' }}
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
import { useBranchStore } from '../stores/branchStore'

export default {
  name: 'BranchesPage',
  setup() {
    const branchStore = useBranchStore()
    
    // Reactive data
    const showModal = ref(false)
    const selectedBranch = ref(null)
    const searchQuery = ref('')
    const itemsPerPage = ref(10)
    const sortBy = ref('nama')
    const sortDesc = ref(false)
    
    const formData = ref({
      nama: '',
      alamat: '',
      latitude: '',
      longitude: ''
    })

    // Computed properties
    const filteredBranches = computed(() => {
      if (!searchQuery.value) return branchStore.branches
      
      return branchStore.branches.filter(branch =>
        branch.nama?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        branch.alamat?.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    })

    const sortedBranches = computed(() => {
      const branches = [...filteredBranches.value]
      
      return branches.sort((a, b) => {
        const aValue = a[sortBy.value] || ''
        const bValue = b[sortBy.value] || ''
        
        if (sortDesc.value) {
          return bValue.localeCompare(aValue)
        } else {
          return aValue.localeCompare(bValue)
        }
      })
    })

    const paginatedBranches = computed(() => {
      const start = 0
      const end = itemsPerPage.value
      return sortedBranches.value.slice(start, end)
    })

    // Methods
    const openModal = (branch = null) => {
      selectedBranch.value = branch
      if (branch) {
        formData.value = { ...branch }
      } else {
        formData.value = {
          nama: '',
          alamat: '',
          latitude: '',
          longitude: ''
        }
      }
      showModal.value = true
    }

    const closeModal = () => {
      showModal.value = false
      selectedBranch.value = null
      formData.value = {
        nama: '',
        alamat: '',
        latitude: '',
        longitude: ''
      }
    }

    const handleSubmit = async () => {
      try {
        if (selectedBranch.value) {
          // Update existing branch
          await branchStore.updateBranch(selectedBranch.value.id, formData.value)
        } else {
          // Create new branch
          await branchStore.createBranch(formData.value)
        }
        closeModal()
      } catch (error) {
        console.error('Error saving branch:', error)
        alert('Error saving branch: ' + error.message)
      }
    }

    const handleDelete = async (branch) => {
      if (confirm(`Are you sure you want to delete ${branch.nama}?`)) {
        try {
          await branchStore.deleteBranch(branch.id)
        } catch (error) {
          console.error('Error deleting branch:', error)
          alert('Error deleting branch: ' + error.message)
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

    const loadBranches = async () => {
      try {
        await branchStore.fetchBranches()
      } catch (error) {
        console.error('Error loading branches:', error)
      }
    }

    // Load branches on component mount
    onMounted(() => {
      loadBranches()
    })

    return {
      branchStore,
      showModal,
      selectedBranch,
      searchQuery,
      itemsPerPage,
      sortBy,
      sortDesc,
      formData,
      paginatedBranches,
      openModal,
      closeModal,
      handleSubmit,
      handleDelete,
      toggleSort,
      loadBranches
    }
  }
}
</script>