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
              <h1 class="text-xl font-semibold text-gray-900">Broadcast Message</h1>
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
            <!-- Page Title -->
            <div class="mb-8">
              <h1 class="text-3xl font-bold text-gray-900 mb-2">Send Broadcast Message</h1>
              <p class="text-gray-600">Send a message to all users in the system via email</p>
            </div>

            <!-- Broadcast Form -->
            <div class="bg-white rounded-lg shadow-sm border">
              <div class="p-6">
                <form @submit.prevent="sendBroadcastMessage" class="space-y-6">
                  <!-- Message Content -->
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                      Message Content
                    </label>
                    <div class="border border-gray-300 rounded-lg">
                      <!-- Simple Textarea (Rich Editor disabled for now) -->
                      <textarea
                        v-model="messageContent"
                        rows="10"
                        class="w-full p-4 border-0 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Type your broadcast message here..."
                      ></textarea>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                      <p class="text-sm text-gray-500">
                        This message will be sent to all users via email.
                      </p>
                      <button
                        type="button"
                        @click="toggleEditor"
                        class="text-sm text-gray-400 cursor-not-allowed"
                        disabled
                      >
                        Rich Editor (Coming Soon)
                      </button>
                    </div>
                  </div>

                  <!-- Message Preview -->
                  <div v-if="messageContent && messageContent.trim()" class="bg-gray-50 rounded-lg p-4 border">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Preview:</h3>
                    <div class="text-sm text-gray-600 whitespace-pre-wrap" v-if="!useRichEditor">{{ messageContent }}</div>
                    <div class="text-sm text-gray-600" v-else v-html="messageContent"></div>
                  </div>

                  <!-- Send Options -->
                  <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex items-start">
                      <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <div>
                        <h3 class="text-sm font-medium text-blue-800">Important Information</h3>
                        <p class="text-sm text-blue-700 mt-1">
                          This message will be sent immediately to all registered users via email. 
                          Please review your message carefully before sending.
                        </p>
                      </div>
                    </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="flex items-center justify-between pt-6 border-t">
                    <div class="text-sm text-gray-500">
                      Total Recipients: <span class="font-medium">{{ totalUsers || 'Loading...' }}</span>
                    </div>
                    <div class="flex space-x-3">
                      <button
                        type="button"
                        @click="clearMessage"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                        :disabled="isLoading || !messageContent || !messageContent.trim()"
                      >
                        Clear
                      </button>
                      <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center"
                        :disabled="isLoading || !messageContent || !messageContent.trim()"
                      >
                        <svg v-if="isLoading" class="animate-spin w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <svg v-else class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        {{ isLoading ? 'Sending...' : 'Send Broadcast' }}
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Recent Broadcasts -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border">
              <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Recent Broadcast Messages</h2>
                <div v-if="recentBroadcasts.length === 0" class="text-center py-8 text-gray-500">
                  No recent broadcast messages
                </div>
                <div v-else class="space-y-4">
                  <div
                    v-for="broadcast in recentBroadcasts"
                    :key="broadcast.id"
                    class="border rounded-lg p-4 hover:bg-gray-50 transition-colors"
                  >
                    <div class="flex items-start justify-between">
                      <div class="flex-1">
                        <div class="text-sm text-gray-500 mb-1">
                          {{ formatDate(broadcast.sent_at) }}
                        </div>
                        <div class="text-gray-900 whitespace-pre-wrap">{{ broadcast.message.substring(0, 200) + (broadcast.message.length > 200 ? '...' : '') }}</div>
                      </div>
                      <div class="ml-4 text-sm text-gray-500">
                        {{ broadcast.recipients_count }} recipients
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <!-- Success Modal -->
    <div v-if="showSuccessModal" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
      <div class="w-full max-w-md p-6 bg-white rounded-lg">
        <div class="text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Message Sent Successfully!</h3>
          <p class="text-gray-600 mb-6">Your broadcast message has been sent to all users.</p>
          <button
            @click="showSuccessModal = false"
            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useAuthStore } from '../stores/authStore'
import Sidebar from '../components/layout/Sidebar.vue'

export default {
  name: 'BroadcastPage',
  components: {
    Sidebar
  },
  setup() {
    const authStore = useAuthStore()
    const messageContent = ref('')
    const isLoading = ref(false)
    const showSuccessModal = ref(false)
    const totalUsers = ref(null)
    const recentBroadcasts = ref([])
    const useRichEditor = ref(false)
    
    // For now, disable rich editor until CKEditor is properly configured
    const isCKEditorAvailable = ref(false)

    // Toggle between rich and simple editor
    const toggleEditor = () => {
      alert('Rich editor will be available in the next update. Currently using simple text editor.')
    }

    // Load total users count
    const loadTotalUsers = async () => {
      try {
        const response = await api.get('/dashboard')
        totalUsers.value = response.data.total_customers || 0
      } catch (error) {
        console.error('Error loading total users:', error)
        totalUsers.value = 'Unknown'
      }
    }

    // Load recent broadcasts (mock data for now)
    const loadRecentBroadcasts = () => {
      // This would normally come from an API
      recentBroadcasts.value = [
        {
          id: 1,
          message: 'Welcome to our new laundry service! We are excited to serve you.',
          sent_at: new Date(Date.now() - 86400000), // 1 day ago
          recipients_count: 150
        },
        {
          id: 2,
          message: 'System maintenance scheduled for this weekend. Please plan accordingly.',
          sent_at: new Date(Date.now() - 86400000 * 3), // 3 days ago
          recipients_count: 150
        }
      ]
    }

    // Send broadcast message
    const sendBroadcastMessage = async () => {
      if (!messageContent.value || !messageContent.value.trim()) {
        alert('Please enter a message to broadcast.')
        return
      }

      isLoading.value = true

      try {
        const response = await api.post('/broadcast/send-now', {
          message: messageContent.value
        })

        if (response.data.success) {
          showSuccessModal.value = true
          clearMessage()
          loadRecentBroadcasts() // Reload recent broadcasts
        } else {
          throw new Error(response.data.message || 'Failed to send broadcast')
        }

      } catch (error) {
        console.error('Error sending broadcast:', error)
        alert('Error sending broadcast message: ' + (error.response?.data?.message || error.message))
      } finally {
        isLoading.value = false
      }
    }

    // Clear message
    const clearMessage = () => {
      messageContent.value = ''
    }

    // Format date
    const formatDate = (date) => {
      return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }

    // Handle logout
    const handleLogout = async () => {
      try {
        await authStore.logout()
        // Router will be handled by the auth store
      } catch (error) {
        console.error('Logout error:', error)
      }
    }

    // Lifecycle hooks
    onMounted(async () => {
      loadTotalUsers()
      loadRecentBroadcasts()
    })

    return {
      authStore,
      messageContent,
      isLoading,
      showSuccessModal,
      totalUsers,
      recentBroadcasts,
      useRichEditor,
      isCKEditorAvailable,
      sendBroadcastMessage,
      clearMessage,
      formatDate,
      handleLogout,
      toggleEditor
    }
  }
}
</script>

<style scoped>
/* CKEditor custom styles */
:deep(.ck-editor__editable) {
  min-height: 300px;
  border: none !important;
  box-shadow: none !important;
}

:deep(.ck-editor__main) {
  border: none !important;
}

:deep(.ck-toolbar) {
  border: none !important;
  border-bottom: 1px solid #e5e7eb !important;
  background: #f9fafb !important;
}

:deep(.ck-content) {
  padding: 1rem !important;
}
</style>
