<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Transactions Management</h1>
      <button @click="openCreateForm" class="flex items-center btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        New Transaction
      </button>
    </div>

    <!-- Error Message -->
    <div v-if="transactionStore.error" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
      <p class="text-red-700">{{ transactionStore.error }}</p>
      <button @click="transactionStore.clearError()" class="mt-2 text-sm text-red-600 hover:text-red-800">
        Dismiss
      </button>
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
                <th class="pb-4">Date</th>
                <th class="pb-4">Amount</th>
                <th class="pb-4">Payment Status</th>
                <th class="pb-4">Laundry Status</th>
                <th class="pb-4">Notes</th>
                <th class="pb-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="transactionStore.loading" class="animate-pulse">
                <td colspan="9" class="py-4 text-center">Loading...</td>
              </tr>
              <tr v-else-if="paginatedTransactions.length === 0" class="border-t">
                <td colspan="9" class="py-4 text-center text-gray-500">No transactions found</td>
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
                <td class="py-4">{{ formatDate(transaction.transaction_date) }}</td>
                <td class="py-4 font-semibold">Rp {{ Number(transaction.total_amount || 0).toLocaleString() }}</td>
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
                </td>
                <td class="py-4">
                  <span class="text-sm text-gray-600">{{ transaction.notes || '-' }}</span>
                </td>
                <td class="py-4">
                  <div class="flex items-center space-x-2">
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
                    <button
                      @click="confirmDelete(transaction)"
                      class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                      title="Delete"
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
      v-if="showForm"
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
import { ref, computed, onMounted } from 'vue'
import { useTransactionStore } from '../stores/transactionStore'
import { useCustomerStore } from '../stores/customerStore'
import { useBranchStore } from '../stores/branchStore'
import TransactionForm from '../components/TransactionForm.vue'

export default {
  name: 'TransactionsPage',
  components: {
    TransactionForm
  },
  setup() {
    const transactionStore = useTransactionStore()
    const customerStore = useCustomerStore()
    const branchStore = useBranchStore()

    // Reactive data
    const showForm = ref(false)
    const showDeleteConfirm = ref(false)
    const transactionToDelete = ref(null)
    const searchQuery = ref('')
    const itemsPerPage = ref(10)
    const currentPage = ref(1)

    // Computed properties
    const filteredTransactions = computed(() => {
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
      const transactions = filteredTransactions.value || []
      const start = (currentPage.value - 1) * itemsPerPage.value
      const end = start + itemsPerPage.value
      return transactions.slice(start, end)
    })

    const totalPages = computed(() => {
      const total = filteredTransactions.value?.length || 0
      return Math.ceil(total / itemsPerPage.value) || 1
    })

    // Methods
    const formatDate = (date) => {
      if (!date) return '-'
      return new Date(date).toLocaleDateString('id-ID')
    }

    const openCreateForm = () => {
      editingTransaction.value = null
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
      try {
        await transactionStore.createTransaction(transactionData)
        alert('Transaction created successfully!')
        closeForm()
      } catch (error) {
        console.error('Error creating transaction:', error)
        alert('Error creating transaction: ' + error.message)
      }
    }

    const confirmDelete = (transaction) => {
      transactionToDelete.value = transaction
      showDeleteConfirm.value = true
    }

    const deleteTransaction = async () => {
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

    const loadData = async () => {
      try {
        await Promise.allSettled([
          transactionStore.fetchTransactions(),
          customerStore.fetchCustomers(),
          branchStore.fetchBranches()
        ])
      } catch (error) {
        console.error('Error loading data:', error)
      }
    }

    // Load data on component mount
    onMounted(() => {
      loadData()
    })

    return {
      transactionStore,
      customerStore,
      branchStore,
      showForm,
      showDeleteConfirm,
      transactionToDelete,
      searchQuery,
      itemsPerPage,
      currentPage,
      totalPages,
      filteredTransactions,
      paginatedTransactions,
      formatDate,
      openCreateForm,
      openPaymentLink,
      closeForm,
      handleSubmit,
      confirmDelete,
      deleteTransaction,
      loadData
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

.btn-primary:hover {
  background-color: #1d4ed8;
}

.btn-primary:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
</style>