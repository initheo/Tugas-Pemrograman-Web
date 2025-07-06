<template>
  <div class="p-6">
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Profile</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your account information</p>
      </div>

      <!-- Profile Card -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">User Information</h2>
        </div>
        
        <div class="p-6">
          <!-- Profile Avatar Section -->
          <div class="flex items-center space-x-6 mb-6">
            <div class="relative">
              <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center">
                <span class="text-2xl font-semibold text-white">
                  {{ getInitials(authStore.currentUser?.name || 'User') }}
                </span>
              </div>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900">
                {{ authStore.currentUser?.name || 'Unknown User' }}
              </h3>
              <p class="text-sm text-gray-600">
                {{ authStore.currentUser?.email || 'No email' }}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                Member since {{ formatDate(authStore.currentUser?.created_at) }}
              </p>
            </div>
          </div>

          <!-- Edit Name Form -->
          <div class="border-t pt-6">
            <form @submit.prevent="updateProfile" class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                  Full Name
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  placeholder="Enter your full name"
                />
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                  Email Address
                </label>
                <input
                  id="email"
                  type="email"
                  :value="authStore.currentUser?.email"
                  disabled
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                />
                <p class="mt-1 text-xs text-gray-500">Email cannot be changed</p>
              </div>

              <!-- Error/Success Messages -->
              <div v-if="error" class="p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
                {{ error }}
              </div>
              
              <div v-if="success" class="p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">
                {{ success }}
              </div>

              <!-- Action Buttons -->
              <div class="flex justify-end space-x-3 pt-4">
                <button
                  type="button"
                  @click="resetForm"
                  class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="loading || !hasChanges"
                  class="px-4 py-2 text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                >
                  <span v-if="loading" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Updating...
                  </span>
                  <span v-else>Update Profile</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Account Information -->
      <div class="mt-6 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Account Details</h2>
        </div>
        
        <div class="p-6">
          <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">User ID</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ authStore.currentUser?.id || 'N/A' }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Account Status</dt>
              <dd class="mt-1">
                <span class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                  Active
                </span>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Last Login</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ formatDate(new Date()) }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
              <dd class="mt-1">
                <span class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                  Verified
                </span>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '../stores/authStore'

export default {
  name: 'ProfilePage',
  setup() {
    const authStore = useAuthStore()
    
    // Reactive data
    const loading = ref(false)
    const error = ref('')
    const success = ref('')
    
    const form = ref({
      name: ''
    })

    // Computed properties
    const hasChanges = computed(() => {
      return form.value.name !== authStore.currentUser?.name
    })

    // Methods
    const getInitials = (name) => {
      return name
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .toUpperCase()
        .slice(0, 2)
    }

    const formatDate = (date) => {
      if (!date) return 'N/A'
      try {
        return new Date(date).toLocaleDateString('id-ID', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        })
      } catch {
        return 'N/A'
      }
    }

    const resetForm = () => {
      form.value.name = authStore.currentUser?.name || ''
      error.value = ''
      success.value = ''
    }

    const updateProfile = async () => {
      if (!hasChanges.value) return

      loading.value = true
      error.value = ''
      success.value = ''

      try {
        // Simulate API call - replace with actual API
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        // Update user in store (mock implementation)
        if (authStore.currentUser) {
          authStore.currentUser.name = form.value.name
          // Update localStorage
          localStorage.setItem('user', JSON.stringify(authStore.currentUser))
        }

        success.value = 'Profile updated successfully!'
        
        // Clear success message after 3 seconds
        setTimeout(() => {
          success.value = ''
        }, 3000)

      } catch (err) {
        error.value = err.message || 'Failed to update profile. Please try again.'
      } finally {
        loading.value = false
      }
    }

    // Initialize form
    onMounted(() => {
      resetForm()
    })

    return {
      authStore,
      form,
      loading,
      error,
      success,
      hasChanges,
      getInitials,
      formatDate,
      resetForm,
      updateProfile
    }
  }
}
</script>

<style scoped>
/* Additional styles if needed */
</style>
