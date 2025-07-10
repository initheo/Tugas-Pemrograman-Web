<template>
  <div class="p-6">
    <!-- Admin View -->
    <div v-if="authStore.user?.role === 'admin'">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Services Management</h1>
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
          Add Service
        </button>
      </div>

      <!-- Search and Filter -->
      <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search services..."
              class="w-64 px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
            <svg
              class="absolute w-5 h-5 text-gray-400 right-3 top-2.5"
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
            v-model="filterStatus"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <div class="flex items-center gap-2">
          <span class="text-sm text-gray-600">Items per page:</span>
          <select
            v-model="itemsPerPage"
            class="px-3 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option :value="10">10</option>
            <option :value="25">25</option>
            <option :value="50">50</option>
          </select>
        </div>
      </div>

      <!-- Services Table -->
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Service Name
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Description
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Price
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Duration
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Service Code
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-if="serviceStore.loading" v-for="n in 5" :key="n">
              <td v-for="i in 7" :key="i" class="px-6 py-4 whitespace-nowrap">
                <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
              </td>
            </tr>
            
            <tr v-else-if="paginatedServices.length === 0">
              <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                <div class="flex flex-col items-center">
                  <svg class="w-12 h-12 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m6-8v2m0 6v2" />
                  </svg>
                  <p class="text-lg font-medium">No services found</p>
                  <p class="text-sm text-gray-400">Get started by creating a new service</p>
                </div>
              </td>
            </tr>

            <tr v-else v-for="service in paginatedServices" :key="service.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ service.name }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900 max-w-xs truncate" :title="service.description">
                  {{ service.description || '-' }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">Rp {{ formatPrice(service.price) }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ service.duration }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ service.service_code || '-' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <button
                  @click="toggleStatus(service)"
                  :class="[
                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full transition-colors duration-200',
                    service.is_active
                      ? 'bg-green-100 text-green-800 hover:bg-green-200'
                      : 'bg-red-100 text-red-800 hover:bg-red-200'
                  ]"
                >
                  {{ service.is_active ? 'Active' : 'Inactive' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-3">
                  <button
                    @click="openEditForm(service)"
                    class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                    title="Edit Service"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button
                    @click="handleDelete(service)"
                    class="text-red-600 hover:text-red-900 transition-colors duration-200"
                    title="Delete Service"
                  >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="flex items-center justify-between mt-6">
        <div class="text-sm text-gray-700">
          Showing {{ startItem }} to {{ endItem }} of {{ filteredServices.length }} results
        </div>
        <div class="flex items-center space-x-2">
          <button
            @click="currentPage = Math.max(1, currentPage - 1)"
            :disabled="currentPage === 1"
            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Previous
          </button>
          
          <span v-for="page in visiblePages" :key="page">
            <button
              v-if="page !== '...'"
              @click="currentPage = page"
              :class="[
                'px-3 py-2 text-sm font-medium border rounded-md',
                currentPage === page
                  ? 'text-blue-600 bg-blue-50 border-blue-500'
                  : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-50'
              ]"
            >
              {{ page }}
            </button>
            <span v-else class="px-3 py-2 text-sm font-medium text-gray-500">...</span>
          </span>
          
          <button
            @click="currentPage = Math.min(totalPages, currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            Next
          </button>
        </div>
      </div>
    </div>

    <!-- User View -->
    <div v-else>
      <div class="mb-6">
        <h1 class="text-2xl font-semibold mb-2">Available Services</h1>
        <p class="text-gray-600">Browse our laundry services and pricing</p>
      </div>

      <!-- Search for users -->
      <div class="mb-6">
        <div class="relative max-w-md">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search services..."
            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <svg
            class="absolute w-5 h-5 text-gray-400 right-3 top-2.5"
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
      </div>

      <!-- Services Grid for Users -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-if="serviceStore.loading" v-for="n in 6" :key="n" class="bg-white rounded-lg shadow-md p-6">
          <div class="h-6 bg-gray-200 rounded animate-pulse mb-4"></div>
          <div class="h-4 bg-gray-200 rounded animate-pulse mb-2"></div>
          <div class="h-4 bg-gray-200 rounded animate-pulse mb-4"></div>
          <div class="h-8 bg-gray-200 rounded animate-pulse"></div>
        </div>

        <div v-else-if="activeServices.length === 0" class="col-span-full text-center py-12">
          <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m6-8v2m0 6v2" />
          </svg>
          <p class="text-xl font-medium text-gray-500 mb-2">No services available</p>
          <p class="text-gray-400">Please check back later</p>
        </div>

        <div v-else v-for="service in activeServices" :key="service.id" class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 p-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ service.name }}</h3>
          <p class="text-gray-600 mb-4 text-sm">{{ service.description || 'No description available' }}</p>
          
          <div class="space-y-2 mb-4">
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Price:</span>
              <span class="font-semibold text-blue-600">Rp {{ formatPrice(service.price) }} / {{ service.unit }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Duration:</span>
              <span class="text-gray-900">{{ service.duration }} hours</span>
            </div>
          </div>

          <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
            Select Service
          </button>
        </div>
      </div>
    </div>

    <!-- Service Form Modal -->
    <ServiceForm
      v-if="showForm"
      :mode="formMode"
      :service="selectedService"
      @close="closeForm"
      @success="handleFormSuccess"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useServiceStore } from '../stores/serviceStore'
import { useAuthStore } from '../stores/authStore'
import ServiceForm from '../components/ServiceForm.vue'

const serviceStore = useServiceStore()
const authStore = useAuthStore()

// Form state
const showForm = ref(false)
const selectedService = ref(null)
const formMode = ref('create')

// Filters and pagination
const searchQuery = ref('')
const filterStatus = ref('')
const itemsPerPage = ref(10)
const currentPage = ref(1)

// Computed properties
const filteredServices = computed(() => {
  let filtered = serviceStore.services

  // Apply search filter
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(service =>
      service.name?.toLowerCase().includes(query) ||
      service.description?.toLowerCase().includes(query) ||
      service.service_code?.toLowerCase().includes(query)
    )
  }

  // Apply status filter
  if (filterStatus.value === 'active') {
    filtered = filtered.filter(service => service.is_active)
  } else if (filterStatus.value === 'inactive') {
    filtered = filtered.filter(service => !service.is_active)
  }

  return filtered
})

const activeServices = computed(() => {
  let filtered = serviceStore.services.filter(service => service.is_active)
  
  // Apply search filter for users
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(service =>
      service.name?.toLowerCase().includes(query) ||
      service.description?.toLowerCase().includes(query)
    )
  }
  
  return filtered
})

const totalPages = computed(() => Math.ceil(filteredServices.value.length / itemsPerPage.value))

const paginatedServices = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredServices.value.slice(start, end)
})

const startItem = computed(() => (currentPage.value - 1) * itemsPerPage.value + 1)
const endItem = computed(() => Math.min(currentPage.value * itemsPerPage.value, filteredServices.value.length))

const visiblePages = computed(() => {
  const pages = []
  const total = totalPages.value
  const current = currentPage.value

  if (total <= 7) {
    for (let i = 1; i <= total; i++) {
      pages.push(i)
    }
  } else {
    pages.push(1)
    if (current > 4) pages.push('...')
    
    const start = Math.max(2, current - 2)
    const end = Math.min(total - 1, current + 2)
    
    for (let i = start; i <= end; i++) {
      pages.push(i)
    }
    
    if (current < total - 3) pages.push('...')
    pages.push(total)
  }
  
  return pages
})

// Methods
const loadServices = async () => {
  try {
    await serviceStore.fetchServices()
  } catch (error) {
    console.error('Failed to load services:', error)
  }
}

const openCreateForm = () => {
  selectedService.value = null
  formMode.value = 'create'
  showForm.value = true
}

const openEditForm = (service) => {
  selectedService.value = service
  formMode.value = 'edit'
  showForm.value = true
}

const closeForm = () => {
  showForm.value = false
  selectedService.value = null
}

const handleFormSuccess = () => {
  closeForm()
  loadServices()
}

const toggleStatus = async (service) => {
  try {
    await serviceStore.toggleServiceStatus(service.id)
  } catch (error) {
    console.error('Failed to toggle service status:', error)
  }
}

const handleDelete = async (service) => {
  if (confirm(`Are you sure you want to delete "${service.name}"?`)) {
    try {
      await serviceStore.deleteService(service.id)
    } catch (error) {
      console.error('Failed to delete service:', error)
    }
  }
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('id-ID').format(price)
}

// Watch for pagination changes
watch([searchQuery, filterStatus], () => {
  currentPage.value = 1
})

// Load services on mount
onMounted(() => {
  loadServices()
})
</script>
