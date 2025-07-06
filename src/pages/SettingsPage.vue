<template>
  <div class="p-6">
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your account settings and preferences</p>
      </div>

      <!-- Change Password Section -->
      <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Change Password</h2>
          <p class="mt-1 text-sm text-gray-600">Update your password to keep your account secure</p>
        </div>
        
        <div class="p-6">
          <form @submit.prevent="changePassword" class="space-y-4">
            <div>
              <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-2">
                Current Password
              </label>
              <div class="relative">
                <input
                  id="currentPassword"
                  v-model="passwordForm.currentPassword"
                  :type="showCurrentPassword ? 'text' : 'password'"
                  required
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  placeholder="Enter your current password"
                />
                <button
                  type="button"
                  @click="showCurrentPassword = !showCurrentPassword"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                >
                  <svg v-if="showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                  </svg>
                </button>
              </div>
            </div>

            <div>
              <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">
                New Password
              </label>
              <div class="relative">
                <input
                  id="newPassword"
                  v-model="passwordForm.newPassword"
                  :type="showNewPassword ? 'text' : 'password'"
                  required
                  minlength="8"
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  placeholder="Enter your new password"
                />
                <button
                  type="button"
                  @click="showNewPassword = !showNewPassword"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                >
                  <svg v-if="showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                  </svg>
                </button>
              </div>
              <div class="mt-2">
                <div class="text-xs text-gray-600">
                  Password strength: 
                  <span :class="passwordStrengthClass">{{ passwordStrength.text }}</span>
                </div>
                <div class="mt-1 bg-gray-200 rounded-full h-2">
                  <div 
                    :class="passwordStrengthClass"
                    class="h-2 rounded-full transition-all duration-300"
                    :style="{ width: passwordStrength.width }"
                  ></div>
                </div>
              </div>
            </div>

            <div>
              <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                Confirm New Password
              </label>
              <div class="relative">
                <input
                  id="confirmPassword"
                  v-model="passwordForm.confirmPassword"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  required
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                  :class="{ 'border-red-300': passwordForm.confirmPassword && !passwordsMatch }"
                  placeholder="Confirm your new password"
                />
                <button
                  type="button"
                  @click="showConfirmPassword = !showConfirmPassword"
                  class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                >
                  <svg v-if="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                  </svg>
                </button>
              </div>
              <p v-if="passwordForm.confirmPassword && !passwordsMatch" class="mt-1 text-xs text-red-600">
                Passwords do not match
              </p>
            </div>

            <!-- Password Requirements -->
            <div class="bg-gray-50 p-4 rounded-lg">
              <h4 class="text-sm font-medium text-gray-900 mb-2">Password Requirements:</h4>
              <ul class="text-xs text-gray-600 space-y-1">
                <li class="flex items-center">
                  <svg :class="passwordRequirements.length ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  At least 8 characters long
                </li>
                <li class="flex items-center">
                  <svg :class="passwordRequirements.uppercase ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  Contains uppercase letter
                </li>
                <li class="flex items-center">
                  <svg :class="passwordRequirements.lowercase ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  Contains lowercase letter
                </li>
                <li class="flex items-center">
                  <svg :class="passwordRequirements.number ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                  </svg>
                  Contains number
                </li>
              </ul>
            </div>

            <!-- Error/Success Messages -->
            <div v-if="passwordError" class="p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
              {{ passwordError }}
            </div>
            
            <div v-if="passwordSuccess" class="p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">
              {{ passwordSuccess }}
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-4">
              <button
                type="button"
                @click="resetPasswordForm"
                class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="passwordLoading || !isPasswordFormValid"
                class="px-4 py-2 text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
              >
                <span v-if="passwordLoading" class="flex items-center">
                  <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg>
                  Changing...
                </span>
                <span v-else>Change Password</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Account Security Section -->
      <div class="mt-6 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
          <h2 class="text-lg font-medium text-gray-900">Account Security</h2>
        </div>
        
        <div class="p-6">
          <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
              <div>
                <h3 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
                <p class="text-sm text-gray-600">Add an extra layer of security to your account</p>
              </div>
              <button class="px-3 py-1 text-sm text-blue-600 border border-blue-300 rounded-lg hover:bg-blue-50">
                Enable
              </button>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
              <div>
                <h3 class="text-sm font-medium text-gray-900">Login Sessions</h3>
                <p class="text-sm text-gray-600">Manage your active login sessions</p>
              </div>
              <button class="px-3 py-1 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100">
                View Sessions
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import { useAuthStore } from '../stores/authStore'

export default {
  name: 'SettingsPage',
  setup() {
    const authStore = useAuthStore()
    
    // Reactive data
    const passwordLoading = ref(false)
    const passwordError = ref('')
    const passwordSuccess = ref('')
    
    const showCurrentPassword = ref(false)
    const showNewPassword = ref(false)
    const showConfirmPassword = ref(false)
    
    const passwordForm = ref({
      currentPassword: '',
      newPassword: '',
      confirmPassword: ''
    })

    // Computed properties
    const passwordsMatch = computed(() => {
      return passwordForm.value.newPassword === passwordForm.value.confirmPassword
    })

    const passwordRequirements = computed(() => {
      const password = passwordForm.value.newPassword
      return {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password)
      }
    })

    const passwordStrength = computed(() => {
      const requirements = passwordRequirements.value
      const score = Object.values(requirements).filter(Boolean).length
      
      switch (score) {
        case 0:
        case 1:
          return { text: 'Weak', width: '25%', class: 'bg-red-500' }
        case 2:
          return { text: 'Fair', width: '50%', class: 'bg-yellow-500' }
        case 3:
          return { text: 'Good', width: '75%', class: 'bg-blue-500' }
        case 4:
          return { text: 'Strong', width: '100%', class: 'bg-green-500' }
        default:
          return { text: 'Weak', width: '0%', class: 'bg-gray-300' }
      }
    })

    const passwordStrengthClass = computed(() => {
      return passwordStrength.value.class
    })

    const isPasswordFormValid = computed(() => {
      return passwordForm.value.currentPassword &&
             passwordForm.value.newPassword &&
             passwordForm.value.confirmPassword &&
             passwordsMatch.value &&
             Object.values(passwordRequirements.value).every(Boolean)
    })

    // Methods
    const resetPasswordForm = () => {
      passwordForm.value = {
        currentPassword: '',
        newPassword: '',
        confirmPassword: ''
      }
      passwordError.value = ''
      passwordSuccess.value = ''
    }

    const changePassword = async () => {
      if (!isPasswordFormValid.value) return

      passwordLoading.value = true
      passwordError.value = ''
      passwordSuccess.value = ''

      try {
        // Simulate API call - replace with actual API
        await new Promise(resolve => setTimeout(resolve, 1500))
        
        // Mock validation of current password
        if (passwordForm.value.currentPassword !== 'password') {
          throw new Error('Current password is incorrect')
        }

        // Mock password change
        console.log('Password changed successfully')

        passwordSuccess.value = 'Password changed successfully!'
        resetPasswordForm()
        
        // Clear success message after 3 seconds
        setTimeout(() => {
          passwordSuccess.value = ''
        }, 3000)

      } catch (err) {
        passwordError.value = err.message || 'Failed to change password. Please try again.'
      } finally {
        passwordLoading.value = false
      }
    }

    return {
      authStore,
      passwordForm,
      passwordLoading,
      passwordError,
      passwordSuccess,
      showCurrentPassword,
      showNewPassword,
      showConfirmPassword,
      passwordsMatch,
      passwordRequirements,
      passwordStrength,
      passwordStrengthClass,
      isPasswordFormValid,
      resetPasswordForm,
      changePassword
    }
  }
}
</script>

<style scoped>
/* Additional styles if needed */
</style>
