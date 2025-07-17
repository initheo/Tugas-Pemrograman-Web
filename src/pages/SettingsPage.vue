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
              <h1 class="text-xl font-semibold text-gray-900">Settings</h1>
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
          <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
              <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
              <p class="mt-1 text-sm text-gray-600">Manage your account settings and security</p>
            </div>

            <!-- Security Settings Card -->
            <div class="bg-white shadow rounded-lg">
              <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Security Settings</h2>
              </div>
              
              <div class="p-6">
          <!-- Change Password Form -->
          <div class="max-w-md">
            <h3 class="text-md font-medium text-gray-900 mb-4">Change Password</h3>
            
            <form @submit.prevent="changePassword" class="space-y-4">
              <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                  Current Password
                </label>
                <input
                  id="current_password"
                  v-model="form.current_password"
                  type="password"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  placeholder="Enter your current password"
                />
              </div>

              <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                  New Password
                </label>
                <input
                  id="new_password"
                  v-model="form.new_password"
                  type="password"
                  required
                  minlength="8"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  placeholder="Enter your new password"
                />
                <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
              </div>

              <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                  Confirm New Password
                </label>
                <input
                  id="new_password_confirmation"
                  v-model="form.new_password_confirmation"
                  type="password"
                  required
                  minlength="8"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  placeholder="Confirm your new password"
                />
              </div>

              <!-- Password Strength Indicator -->
              <div v-if="form.new_password" class="mt-2">
                <div class="text-xs text-gray-600 mb-1">Password strength:</div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div 
                    class="h-2 rounded-full transition-all duration-300"
                    :class="passwordStrengthClass"
                    :style="{ width: passwordStrengthWidth }"
                  ></div>
                </div>
                <div class="text-xs mt-1" :class="passwordStrengthTextClass">
                  {{ passwordStrengthText }}
                </div>
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
                  :disabled="loading || !isFormValid"
                  class="px-4 py-2 text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                >
                  <span v-if="loading" class="flex items-center">
                    <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Changing Password...
                  </span>
                  <span v-else>Change Password</span>
                </button>
              </div>
            </form>
          </div>
              </div>
            </div>

            <!-- Additional Settings Card -->
            

          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'
import Sidebar from '../components/Sidebar.vue'

export default {
  name: 'SettingsPage',
  components: {
    Sidebar
  },
  setup() {
    const router = useRouter()
    const authStore = useAuthStore()
    
    // Reactive data
    const loading = ref(false)
    const error = ref('')
    const success = ref('')
    
    const form = ref({
      current_password: '',
      new_password: '',
      new_password_confirmation: ''
    })

    // Computed properties
    const isFormValid = computed(() => {
      return form.value.current_password && 
             form.value.new_password && 
             form.value.new_password_confirmation &&
             form.value.new_password === form.value.new_password_confirmation &&
             form.value.new_password.length >= 8
    })

    const passwordStrength = computed(() => {
      const password = form.value.new_password
      if (!password) return 0
      
      let strength = 0
      
      // Length check
      if (password.length >= 8) strength += 1
      if (password.length >= 12) strength += 1
      
      // Character variety checks
      if (/[a-z]/.test(password)) strength += 1
      if (/[A-Z]/.test(password)) strength += 1
      if (/[0-9]/.test(password)) strength += 1
      if (/[^A-Za-z0-9]/.test(password)) strength += 1
      
      return Math.min(strength, 4)
    })

    const passwordStrengthWidth = computed(() => {
      return `${(passwordStrength.value / 4) * 100}%`
    })

    const passwordStrengthClass = computed(() => {
      switch (passwordStrength.value) {
        case 0:
        case 1:
          return 'bg-red-500'
        case 2:
          return 'bg-yellow-500'
        case 3:
          return 'bg-blue-500'
        case 4:
          return 'bg-green-500'
        default:
          return 'bg-gray-300'
      }
    })

    const passwordStrengthTextClass = computed(() => {
      switch (passwordStrength.value) {
        case 0:
        case 1:
          return 'text-red-600'
        case 2:
          return 'text-yellow-600'
        case 3:
          return 'text-blue-600'
        case 4:
          return 'text-green-600'
        default:
          return 'text-gray-500'
      }
    })

    const passwordStrengthText = computed(() => {
      switch (passwordStrength.value) {
        case 0:
        case 1:
          return 'Weak'
        case 2:
          return 'Fair'
        case 3:
          return 'Good'
        case 4:
          return 'Strong'
        default:
          return ''
      }
    })

    // Methods
    const resetForm = () => {
      form.value = {
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
      }
      error.value = ''
      success.value = ''
    }

    const changePassword = async () => {
      if (!isFormValid.value) return

      loading.value = true
      error.value = ''
      success.value = ''

      try {
        // Call API to change password
        const result = await authStore.changePassword({
          current_password: form.value.current_password,
          new_password: form.value.new_password,
          new_password_confirmation: form.value.new_password_confirmation
        })

        if (result.success) {
          success.value = 'Password changed successfully!'
          resetForm()
          
          // Clear success message after 5 seconds
          setTimeout(() => {
            success.value = ''
          }, 5000)
        } else {
          error.value = result.error || 'Failed to change password'
        }

      } catch (err) {
        console.error('Password change error:', err)
        error.value = err.message || 'Failed to change password. Please try again.'
      } finally {
        loading.value = false
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

    return {
      authStore,
      form,
      loading,
      error,
      success,
      isFormValid,
      passwordStrength,
      passwordStrengthWidth,
      passwordStrengthClass,
      passwordStrengthTextClass,
      passwordStrengthText,
      resetForm,
      changePassword,
      handleLogout
    }
  }
}
</script>

<style scoped>
/* Additional styles if needed */
</style>
