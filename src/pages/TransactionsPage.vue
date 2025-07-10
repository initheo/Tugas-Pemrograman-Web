<template>
  <div class="p-6">
  
    <!-- Error state for store initialization -->
    <div v-if="!transactionStore || !isComponentMounted" class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
      <p class="text-yellow-700">Loading component... Please wait.</p>
    </div>

    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">
        {{ authStore.isAdmin ? 'Transactions Management' : 'My Transactions' }}
      </h1>
      <button @click="openCreateForm" class="flex items-center btn-primary" :disabled="!transactionStore || !isComponentMounted">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        New Transaction
      </button>
    </div>

    <!-- Error Message -->
    <div v-if="transactionStore?.error" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
      <p class="text-red-700">{{ transactionStore.error }}</p>
      <button @click="transactionStore.clearError()" class="mt-2 text-sm text-red-600 hover:text-red-800">
        Dismiss
      </button>
    </div>

    <!-- Role Information -->
    <div v-if="authStore.isUser" class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
      <div class="flex items-center text-blue-700">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm">You can view your transactions and payment status. Laundry status updates are managed by admin.</span>
      </div>
    </div>

    <!-- Transaction list table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <!-- Search and Items per page -->
        <div class="flex items-center justify-between mb-4">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search transactions..."
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

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-sm font-medium text-left text-gray-600 border-b">
                <th class="pb-4">ID</th>
                <th class="pb-4">Customer</th>
                <th class="pb-4">Branch</th>
                <th class="pb-4">Service</th>
                <th class="pb-4">Weight</th>
                <th class="pb-4">Date</th>
                <th class="pb-4">Amount</th>
                <th class="pb-4">Payment Status</th>
                <th class="pb-4">Laundry Status</th>
                <th class="pb-4">Notes</th>
                <th class="pb-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="!isComponentMounted || transactionStore?.loading" class="animate-pulse">
                <td colspan="11" class="py-4 text-center">Loading...</td>
              </tr>
              <tr v-else-if="paginatedTransactions.length === 0" class="border-t">
                <td colspan="11" class="py-4 text-center text-gray-500">No transactions found</td>
              </tr>
              <tr
                v-for="transaction in paginatedTransactions"
                :key="transaction.id"
                class="transition-colors border-t hover:bg-gray-50"
              >
                <td class="py-4 font-medium">#{{ transaction.id }}</td>
                <td class="py-4">
                  <div>
                    <div class="font-medium">{{ transaction.customer?.name || 'Unknown Customer' }}</div>
                    <div class="text-sm text-gray-500">{{ transaction.customer?.email || '' }}</div>
                  </div>
                </td>
                <td class="py-4">
                  <div>
                    <div class="font-medium">{{ transaction.branch_store?.name || 'Unknown Branch' }}</div>
                    <div class="text-sm text-gray-500">{{ transaction.branch_store?.address || '' }}</div>
                  </div>
                </td>
                <td class="py-4">
                  <div v-if="transaction.service">
                    <div class="font-medium">{{ transaction.service.name }}</div>
                    <div class="text-sm text-gray-500">Rp {{ Number(transaction.service.price).toLocaleString() }}/{{ transaction.service.unit || 'kg' }}</div>
                    <div class="text-xs text-gray-400">{{ transaction.service.duration }}</div>
                  </div>
                  <div v-else class="text-gray-400">-</div>
                </td>
                <td class="py-4">
                  <div v-if="transaction.weight">
                    <div class="font-medium">{{ transaction.weight }} kg</div>
                    <div v-if="transaction.service && transaction.service.price" class="text-xs text-gray-500">
                      {{ transaction.weight }} × Rp {{ Number(transaction.service.price).toLocaleString() }}
                    </div>
                  </div>
                  <div v-else class="text-gray-400">-</div>
                </td>
                <td class="py-4">{{ formatDate(transaction.transaction_date) }}</td>
                <td class="py-4 font-semibold">
                  <div>
                    <div class="text-lg">Rp {{ Number(transaction.total_amount || 0).toLocaleString() }}</div>
                    <div v-if="transaction.voucher" class="text-xs text-green-600">
                      Voucher: {{ transaction.voucher.name }} 
                      <span v-if="transaction.discount_amount > 0">
                        (-Rp {{ Number(transaction.discount_amount).toLocaleString() }})
                      </span>
                    </div>
                    <div class="text-xs text-gray-500">
                      {{ transaction.payment_method || 'N/A' }}
                    </div>
                  </div>
                </td>
                <td class="py-4">
                  <span :class="[
                    'px-2 py-1 text-xs rounded-full',
                    {
                      'bg-green-100 text-green-800': transaction.status_payment === 'paid',
                      'bg-yellow-100 text-yellow-800': transaction.status_payment === 'unpaid',
                      'bg-red-100 text-red-800': transaction.status_payment === 'expired'
                    }
                  ]">
                    {{ transaction.status_payment }}
                  </span>
                </td>
                <td class="py-4">
                  <div class="flex items-center justify-between">
                    <span :class="[
                      'px-2 py-1 text-xs rounded-full',
                      {
                        'bg-green-100 text-green-800': transaction.status_laundry === 'completed',
                        'bg-blue-100 text-blue-800': transaction.status_laundry === 'processing',
                        'bg-gray-100 text-gray-800': transaction.status_laundry === 'pending',
                        'bg-red-100 text-red-800': transaction.status_laundry === 'cancelled'
                      }
                    ]">
                      {{ transaction.status_laundry }}
                    </span>
                    
                    <!-- Status Update Button - Admin Only -->
                    <button
                      v-if="authStore.isAdmin && canUpdateLaundryStatus(transaction.status_laundry)"
                      @click="updateLaundryStatus(transaction)"
                      :class="[
                        'ml-2 px-2 py-1 text-xs rounded-lg transition-colors',
                        {
                          'bg-blue-600 text-white hover:bg-blue-700': transaction.status_laundry === 'pending',
                          'bg-green-600 text-white hover:bg-green-700': transaction.status_laundry === 'processing'
                        }
                      ]"
                      :title="getNextStatusText(transaction.status_laundry)"
                    >
                      {{ getNextStatusText(transaction.status_laundry) }}
                    </button>
                    
                    <!-- Status Info for Users -->
                    <div v-else-if="authStore.isUser && canUpdateLaundryStatus(transaction.status_laundry)" class="ml-2 text-xs text-gray-500">
                      {{ getStatusInfoForUser(transaction.status_laundry) }}
                    </div>
                  </div>
                </td>
                <td class="py-4">
                  <span class="text-sm text-gray-600">{{ transaction.notes || '-' }}</span>
                </td>
                <td class="py-4">
                  <div class="flex items-center space-x-2">
                    <!-- Download Invoice Button -->
                    <button
                      v-if="transaction.status_payment === 'paid'"
                      @click="downloadInvoice(transaction)"
                      class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                      title="Download Invoice"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                    </button>
                    <!-- Payment Link Button -->
                    <button
                      v-if="transaction.urlPaymentGateway"
                      @click="openPaymentLink(transaction.urlPaymentGateway)"
                      class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                      title="Open Payment Link"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7h10v10M17 7l-10 10" />
                      </svg>
                    </button>
                    <!-- Check Payment Status Button -->
                    <button
                      v-if="transaction.status_payment === 'unpaid' && transaction.payment_session_id"
                      @click="checkPaymentStatus(transaction)"
                      class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                      title="Check Payment Status"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                      </svg>
                    </button>
                    <!-- Refresh Transaction Button -->
                    <button
                      @click="refreshTransaction(transaction)"
                      class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                      title="Refresh Transaction"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                      </svg>
                    </button>
                    <!-- Delete Button - Admin Only -->
                    <button
                      v-if="authStore.isAdmin"
                      @click="confirmDelete(transaction)"
                      class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                      title="Delete Transaction"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="flex items-center justify-between mt-4">
          <div class="text-sm text-gray-600">
            Showing {{ ((currentPage - 1) * itemsPerPage) + 1 }} to
            {{ Math.min(currentPage * itemsPerPage, filteredTransactions.length) }} of
            {{ filteredTransactions.length }} entries
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

    <!-- Transaction Form Modal -->
    <TransactionForm
      v-if="showForm && transactionStore && isComponentMounted"
      :loading="transactionStore.loading"
      @close="closeForm"
      @submit="handleSubmit"
    />

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteConfirm" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
      <div class="w-full max-w-md p-6 bg-white rounded-lg">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>
          <button @click="showDeleteConfirm = false" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <p class="text-gray-700 mb-6">
          Are you sure you want to delete transaction #{{ transactionToDelete?.id }}? This action cannot be undone.
        </p>
        <div class="flex justify-end space-x-3">
          <button
            @click="showDeleteConfirm = false"
            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50"
          >
            Cancel
          </button>
          <button
            @click="deleteTransaction"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useTransactionStore } from '../stores/transactionStore'
import { useCustomerStore } from '../stores/customerStore'
import { useBranchStore } from '../stores/branchStore'
import { useVoucherStore } from '../stores/voucherStore'
import { useAuthStore } from '../stores/authStore'
import api from '../services/api'
import TransactionForm from '../components/TransactionForm.vue'

export default {
  name: 'TransactionsPage',
  components: {
    TransactionForm
  },
  setup() {
    // Initialize stores with error handling
    let transactionStore, customerStore, branchStore, voucherStore, authStore
    
    try {
      transactionStore = useTransactionStore()
      customerStore = useCustomerStore()
      branchStore = useBranchStore()
      voucherStore = useVoucherStore()
      authStore = useAuthStore()
    } catch (error) {
      console.error('Error initializing stores:', error)
      // Return minimal setup to prevent crashes
      return {
        error: 'Failed to initialize stores'
      }
    }

    // Reactive data
    const showForm = ref(false)
    const showDeleteConfirm = ref(false)
    const transactionToDelete = ref(null)
    const searchQuery = ref('')
    const itemsPerPage = ref(10)
    const currentPage = ref(1)
    const isComponentMounted = ref(false)

    // Computed properties with safety checks
    const filteredTransactions = computed(() => {
      if (!transactionStore || !isComponentMounted.value) return []
      const transactions = transactionStore.transactions || []
      if (!searchQuery.value) return transactions

      return transactions.filter(transaction => {
        const customer = transaction.customer?.name || ''
        const branch = transaction.branch_store?.name || ''
        const status = transaction.status_payment || ''
        const notes = transaction.notes || ''
        
        return (
          customer.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          branch.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          status.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
          notes.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
      })
    })

    const paginatedTransactions = computed(() => {
      if (!isComponentMounted.value) return []
      const transactions = filteredTransactions.value || []
      const start = (currentPage.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return transactions.slice(start, end)
    })

    const totalPages = computed(() => {
      if (!isComponentMounted.value) return 1
      const total = filteredTransactions.value?.length || 0
      return Math.ceil(total / itemsPerPage.value) || 1
    })

    // Methods
    const formatDate = (date) => {
      if (!date) return '-'
      return new Date(date).toLocaleDateString('id-ID')
    }

    const openCreateForm = () => {
      showForm.value = true
    }

    const closeForm = () => {
      showForm.value = false
    }

    const openPaymentLink = (url) => {
      if (url) {
        window.open(url, '_blank')
      }
    }

    const handleSubmit = async (transactionData) => {
      if (!transactionStore || !isComponentMounted.value) {
        alert('Component not ready. Please try again.')
        return
      }
      
      try {
        const response = await transactionStore.createTransaction(transactionData)
        
        // Show success message
        if (response.urlPaymentGateway) {
          alert('Transaction created successfully! Payment link has been opened.')
        } else {
          alert('Transaction created successfully!')
        }
        
        closeForm()
      } catch (error) {
        console.error('Error creating transaction:', error)
        alert('Error creating transaction: ' + (error.response?.data?.message || error.message))
      }
    }

    const checkPaymentStatus = async (transaction) => {
      if (!transactionStore || !isComponentMounted.value) {
        alert('Component not ready. Please try again.')
        return
      }
      
      try {
        const response = await transactionStore.checkPaymentStatus(transaction.id)
        
        if (response.data && response.data.transaction) {
          alert(`Payment status updated: ${response.data.transaction.status_payment}`)
        } else {
          alert('Payment status checked successfully!')
        }
      } catch (error) {
        console.error('Error checking payment status:', error)
        alert('Error checking payment status: ' + (error.response?.data?.message || error.message))
      }
    }

    const refreshTransaction = async (transaction) => {
      if (!transactionStore || !isComponentMounted.value) {
        alert('Component not ready. Please try again.')
        return
      }
      
      try {
        console.log('Refreshing transaction:', transaction.id)
        await transactionStore.refreshTransaction(transaction.id)
        alert('Transaction data refreshed!')
      } catch (error) {
        console.error('Error refreshing transaction:', error)
        // Fallback: reload all transactions if single refresh fails
        try {
          await transactionStore.fetchTransactions()
          alert('Transactions list refreshed!')
        } catch (fallbackError) {
          console.error('Error in fallback refresh:', fallbackError)
          alert('Error refreshing transaction: ' + (error.response?.data?.message || error.message))
        }
      }
    }

    const confirmDelete = (transaction) => {
      transactionToDelete.value = transaction
      showDeleteConfirm.value = true
    }

    const deleteTransaction = async () => {
      if (!transactionStore || !isComponentMounted.value) {
        alert('Component not ready. Please try again.')
        return
      }
      
      try {
        await transactionStore.deleteTransaction(transactionToDelete.value.id)
        showDeleteConfirm.value = false
        transactionToDelete.value = null
        alert('Transaction deleted successfully!')
      } catch (error) {
        console.error('Error deleting transaction:', error)
        alert('Error deleting transaction: ' + error.message)
      }
    }

    // Laundry status management functions
    const canUpdateLaundryStatus = (currentStatus) => {
      return currentStatus === 'pending' || currentStatus === 'processing'
    }

    const getNextStatusText = (currentStatus) => {
      if (currentStatus === 'pending') return 'Start Process'
      if (currentStatus === 'processing') return 'Mark Complete'
      return ''
    }

    const getNextStatus = (currentStatus) => {
      if (currentStatus === 'pending') return 'processing'
      if (currentStatus === 'processing') return 'completed'
      return currentStatus
    }

    const getStatusInfoForUser = (currentStatus) => {
      if (currentStatus === 'pending') return 'Waiting to start'
      if (currentStatus === 'processing') return 'In progress'
      return ''
    }

    const updateLaundryStatus = async (transaction) => {
      if (!transactionStore || !isComponentMounted.value) {
        alert('Component not ready. Please try again.')
        return
      }
      
      try {
        const currentStatus = transaction.status_laundry
        const nextStatus = getNextStatus(currentStatus)
        
        if (!nextStatus || nextStatus === currentStatus) {
          return
        }

        const confirmMessage = currentStatus === 'pending' 
          ? `Start processing laundry for transaction #${transaction.id}?`
          : `Mark laundry as completed for transaction #${transaction.id}?`
        
        if (!confirm(confirmMessage)) {
          return
        }

        // Show loading state
        const loadingMessage = nextStatus === 'processing' 
          ? 'Starting laundry process...'
          : 'Marking as completed...'
        
        console.log(loadingMessage)

        await transactionStore.updateLaundryStatus(transaction.id, nextStatus)
        
        const successMessage = nextStatus === 'processing' 
          ? 'Laundry process started successfully!'
          : 'Laundry marked as completed!'
          
        alert(successMessage)
        
        // Refresh the transactions list to show updated status
        await transactionStore.fetchTransactions()
        
      } catch (error) {
        console.error('Error updating laundry status:', error)
        alert('Error updating laundry status: ' + (error.response?.data?.message || error.message))
      }
    }

    const downloadInvoice = async (transaction) => {
      if (transaction.status_payment !== 'paid') {
        alert('Invoice can only be downloaded for paid transactions.')
        return
      }
      
      try {
        console.log('Downloading invoice for transaction:', transaction.id)
        
        // Get auth token
        const token = localStorage.getItem('auth_token')
        
        if (!token) {
          alert('You must be logged in to download invoice.')
          return
        }
        
        // Create download URL
        const baseURL = 'https://laundrease.tugas1.id/api'
        const downloadUrl = `${baseURL}/transactions/${transaction.id}/download-invoice`
        
        console.log('Download URL:', downloadUrl)
        
        // Create a temporary link and trigger download
        const link = document.createElement('a')
        link.href = downloadUrl
        link.download = `invoice_transaction_${transaction.id}.pdf`
        link.target = '_blank'
        
        // For browsers that support it, we'll try to add auth headers
        // But since we can't add custom headers to a simple link click,
        // we'll use fetch first
        try {
          const response = await fetch(downloadUrl, {
            method: 'GET',
            headers: {
              'Authorization': `Bearer ${token}`,
              'Accept': 'application/pdf'
            }
          })
          
          if (response.ok) {
            const blob = await response.blob()
            const url = window.URL.createObjectURL(blob)
            
            const downloadLink = document.createElement('a')
            downloadLink.href = url
            downloadLink.download = `invoice_transaction_${transaction.id}.pdf`
            downloadLink.style.display = 'none'
            
            document.body.appendChild(downloadLink)
            downloadLink.click()
            document.body.removeChild(downloadLink)
            
            window.URL.revokeObjectURL(url)
            
            console.log('Invoice downloaded successfully')
            alert('Invoice downloaded successfully!')
          } else {
            throw new Error(`Server responded with status: ${response.status}`)
          }
          
        } catch (fetchError) {
          console.error('Fetch failed:', fetchError)
          alert('Error downloading invoice: ' + fetchError.message)
        }
        
      } catch (error) {
        console.error('Error downloading invoice:', error)
        alert('Error downloading invoice. Please try again.')
      }
    }

    const loadData = async () => {
      if (!transactionStore || !customerStore || !branchStore || !voucherStore) {
        console.error('Stores not properly initialized')
        return
      }
      
      console.log('Loading data for role:', authStore.role)
      
      try {
        if (authStore.isAdmin) {
          // Admin can see all data
          console.log('Loading admin data...')
          await Promise.allSettled([
            transactionStore.fetchTransactions(),
            customerStore.fetchCustomers(),
            branchStore.fetchBranches(),
            voucherStore.fetchVouchers()
          ])
          console.log('Admin data loaded')
        } else if (authStore.isUser) {
          console.log('Loading user data...')
          const user = authStore.getCurrentUser()
          console.log('Current user:', user)
          
          // User only sees their own transactions and available branches/vouchers
          await Promise.allSettled([
            // User transactions endpoint - will only return user's transactions
            (async () => {
              try {
                console.log('Fetching user transactions...')
                const response = await api.get('/user/transactions')
                console.log('User transactions response:', response.data)
                
                const transactionsData = response.data.data || response.data
                transactionStore.transactions = Array.isArray(transactionsData) ? transactionsData : []
                transactionStore.loading = false
                console.log('User transactions loaded:', transactionStore.transactions.length)
              } catch (error) {
                console.error('Error loading user transactions:', error)
                transactionStore.transactions = []
                transactionStore.loading = false
                
                // If endpoint doesn't exist, try to filter from all transactions
                try {
                  console.log('Trying to fetch all transactions and filter...')
                  await transactionStore.fetchTransactions()
                  const allTransactions = transactionStore.transactions || []
                  const userTransactions = allTransactions.filter(transaction => {
                    return transaction.user_id === user.id || 
                           transaction.customer?.user_id === user.id
                  })
                  transactionStore.transactions = userTransactions
                  console.log('Filtered user transactions:', userTransactions.length)
                } catch (fallbackError) {
                  console.error('Fallback also failed:', fallbackError)
                }
              }
            })(),
            // Load branches for user
            (async () => {
              try {
                console.log('Fetching branches for user...')
                const response = await api.get('/user/branches')
                console.log('User branches response:', response.data)
                
                const branchesData = response.data.data || response.data
                branchStore.branches = Array.isArray(branchesData) ? branchesData : []
                branchStore.loading = false
                console.log('User branches loaded:', branchStore.branches.length)
              } catch (error) {
                console.error('Error loading user branches:', error)
                branchStore.branches = []
                branchStore.loading = false
                
                // Fallback: try to load from admin endpoint (if accessible)
                try {
                  console.log('Trying fallback branches endpoint...')
                  await branchStore.fetchBranches()
                  console.log('Fallback branches loaded:', branchStore.branches?.length || 0)
                } catch (fallbackError) {
                  console.error('Fallback branches loading failed:', fallbackError)
                }
              }
            })(),
            // Load vouchers for user
            (async () => {
              try {
                console.log('Fetching user vouchers...')
                const response = await api.get('/user/vouchers')
                console.log('User vouchers response:', response.data)
                
                const vouchersData = response.data.data || response.data
                voucherStore.vouchers = Array.isArray(vouchersData) ? vouchersData : []
                voucherStore.loading = false
                console.log('User vouchers loaded:', voucherStore.vouchers.length)
              } catch (error) {
                console.error('Error loading user vouchers:', error)
                voucherStore.vouchers = []
                voucherStore.loading = false
                
                // Fallback: try to load from admin endpoint (if accessible)
                try {
                  console.log('Trying fallback vouchers endpoint...')
                  await voucherStore.fetchVouchers()
                  console.log('Fallback vouchers loaded:', voucherStore.vouchers?.length || 0)
                } catch (fallbackError) {
                  console.error('Fallback vouchers loading failed:', fallbackError)
                }
              }
            })()
          ])
          console.log('User data loading completed')
        }
      } catch (error) {
        console.error('Error loading data:', error)
      }
    }

    // Load data on component mount
    onMounted(async () => {
      isComponentMounted.value = true
      await loadData()
    })

    // Cleanup on unmount
    onUnmounted(() => {
      isComponentMounted.value = false
    })

    return {
      authStore,
      transactionStore,
      customerStore,
      branchStore,
      voucherStore,
      showForm,
      showDeleteConfirm,
      transactionToDelete,
      searchQuery,
      itemsPerPage,
      currentPage,
      totalPages,
      filteredTransactions,
      paginatedTransactions,
      isComponentMounted,
      formatDate,
      openCreateForm,
      openPaymentLink,
      closeForm,
      handleSubmit,
      checkPaymentStatus,
      refreshTransaction,
      confirmDelete,
      deleteTransaction,
      loadData,
      canUpdateLaundryStatus,
      getNextStatusText,
      getStatusInfoForUser,
      updateLaundryStatus,
      downloadInvoice
    }
  }
}
</script>

<style scoped>
.btn-primary {
  padding: 0.5rem 1rem;
  background-color: #2563eb;
  color: white;
  border-radius: 0.5rem;
  transition: all 0.2s;
  border: none;
  cursor: pointer;
}

.btn-primary:hover:not(:disabled) {
  background-color: #1d4ed8;
}

.btn-primary:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}

.btn-primary:disabled {
  background-color: #9ca3af;
  cursor: not-allowed;
}
</style>