import { defineStore } from 'pinia'
import { transactionService } from '../services/transactionService'

export const useTransactionStore = defineStore('transaction', {
  state: () => ({
    transactions: [],
    currentTransaction: null,
    loading: false,
    error: null
  }),

  getters: {
    getTransactionById: (state) => (id) => {
      return state.transactions.find(transaction => transaction.id === id)
    },
    totalTransactions: (state) => state.transactions.length,
    pendingTransactions: (state) => state.transactions.filter(t => t.status_payment === 'unpaid'),
    completedTransactions: (state) => state.transactions.filter(t => t.status_payment === 'paid')
  },

  actions: {
    // Fetch all transactions
    async fetchTransactions() {
      this.loading = true
      this.error = null
      
      try {
        const response = await transactionService.getTransactions()
        this.transactions = response.data || response || []
        this.loading = false
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.warn('Failed to fetch transactions from API, using mock data as fallback')
        
        // Mock data fallback
        this.transactions = [
          {
            id: 1,
            customer_id: 1,
            branch_store_id: 1,
            transaction_date: '2024-01-15',
            total_amount: 50000,
            status_payment: 'paid',
            status_laundry: 'completed',
            notes: 'Regular washing',
            customer: { id: 1, name: 'John Doe', email: 'john@example.com' },
            branch_store: { id: 1, name: 'Main Branch', address: 'Jl. Sudirman No. 1' }
          },
          {
            id: 2,
            customer_id: 2,
            branch_store_id: 1,
            transaction_date: '2024-01-16',
            total_amount: 75000,
            status_payment: 'unpaid',
            status_laundry: 'pending',
            notes: 'Express service',
            customer: { id: 2, name: 'Jane Smith', email: 'jane@example.com' },
            branch_store: { id: 1, name: 'Main Branch', address: 'Jl. Sudirman No. 1' }
          }
        ]
      }
    },

    // Fetch single transaction
    async fetchTransaction(id) {
      this.loading = true
      this.error = null
      
      try {
        const response = await transactionService.getTransaction(id)
        this.currentTransaction = response.data || response
        this.loading = false
        return this.currentTransaction
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.warn('Failed to fetch transaction from API, using local data')
        
        // Fallback to find in current transactions
        const transaction = this.transactions.find(t => t.id === parseInt(id))
        this.currentTransaction = transaction || null
        return this.currentTransaction
      }
    },

    // Create new transaction
    async createTransaction(transactionData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await transactionService.createTransaction(transactionData)
        const newTransaction = response.data || response
        
        // Add to local state
        this.transactions.unshift(newTransaction)
        
        // Auto open payment gateway URL if available
        if (newTransaction.urlPaymentGateway && transactionData.payment_method === 'TRANSFER') {
          window.open(newTransaction.urlPaymentGateway, '_blank')
        }
        
        console.log('Transaction created successfully:', newTransaction)
        return newTransaction
      } catch (error) {
        this.error = error.message
        console.error('Failed to create transaction via API:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    // Delete transaction
    async deleteTransaction(id) {
      this.loading = true
      this.error = null
      
      try {
        await transactionService.deleteTransaction(id)
        
        // Remove from local state
        const index = this.transactions.findIndex(t => t.id === parseInt(id))
        if (index !== -1) {
          this.transactions.splice(index, 1)
        }
        
        this.loading = false
        console.log('Transaction deleted successfully')
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.warn('Failed to delete transaction via API, using mock deletion')
        
        // Mock fallback
        const index = this.transactions.findIndex(t => t.id === parseInt(id))
        if (index !== -1) {
          this.transactions.splice(index, 1)
          console.log('Mock transaction deleted:', id)
        } else {
          throw new Error('Transaction not found')
        }
      }
    },

    // Check payment status
    async checkPaymentStatus(id) {
      this.loading = true
      this.error = null
      
      try {
        const response = await transactionService.checkPaymentStatus(id)
        const result = response.data || response
        
        // Update transaction in local state if status changed
        if (result.transaction) {
          const index = this.transactions.findIndex(t => t.id === parseInt(id))
          if (index !== -1) {
            this.transactions[index] = { ...this.transactions[index], ...result.transaction }
          }
        }
        
        this.loading = false
        console.log('Payment status checked:', result)
        return result
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.warn('Failed to check payment status:', error.message)
        throw error
      }
    },

    // Clear error
    clearError() {
      this.error = null
    }
  }
})
