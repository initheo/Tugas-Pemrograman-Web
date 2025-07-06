import { defineStore } from 'pinia'

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
    pendingTransactions: (state) => state.transactions.filter(t => t.statusPembayaran === 'pending'),
    completedTransactions: (state) => state.transactions.filter(t => t.statusPembayaran === 'berhasil')
  },

  actions: {
    // Fetch all transactions
    async fetchTransactions() {
      this.loading = true
      this.error = null
      
      try {
        // Mock data for development - replace with actual API call
        this.transactions = [
          {
            id: 1,
            pelanggan: { id: 1 },
            kantor: { id: 1 },
            tanggal: '2024-01-15',
            berat: 2.5,
            totalNominal: 25000,
            statusCucian: 'selesai',
            statusPembayaran: 'berhasil',
            urlPaymentGateway: '#'
          },
          {
            id: 2,
            pelanggan: { id: 2 },
            kantor: { id: 2 },
            tanggal: '2024-01-16',
            berat: 3.0,
            totalNominal: 30000,
            statusCucian: 'proses',
            statusPembayaran: 'pending',
            urlPaymentGateway: 'https://payment.example.com/pay/2'
          },
          {
            id: 3,
            pelanggan: { id: 3 },
            kantor: { id: 1 },
            tanggal: '2024-01-17',
            berat: 1.5,
            totalNominal: 15000,
            statusCucian: 'pending',
            statusPembayaran: 'pending',
            urlPaymentGateway: 'https://payment.example.com/pay/3'
          }
        ]
        this.loading = false
        console.log('Transactions loaded (mock data):', this.transactions)
      } catch (error) {
        this.error = error.message
        this.transactions = [] // Pastikan transactions tetap array meskipun ada error
        this.loading = false
        console.warn('Failed to fetch transactions, using empty array')
        throw error
      }
    },

    // Fetch single transaction
    async fetchTransaction(id) {
      this.loading = true
      this.error = null
      
      try {
        // Mock implementation - replace with actual API call
        const transaction = this.transactions.find(t => t.id === parseInt(id))
        this.currentTransaction = transaction || null
        this.loading = false
        return this.currentTransaction
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Create new transaction
    async createTransaction(transactionData) {
      this.loading = true
      this.error = null
      
      try {
        // Mock implementation - replace with actual API call
        const newTransaction = {
          id: this.transactions.length + 1,
          ...transactionData,
          tanggal: new Date().toISOString().split('T')[0],
          statusCucian: 'pending',
          statusPembayaran: transactionData.paymentMethod === 'CASH' ? 'berhasil' : 'pending',
          urlPaymentGateway: transactionData.paymentMethod === 'TRANSFER' 
            ? `https://payment.example.com/pay/${this.transactions.length + 1}` 
            : null
        }
        
        this.transactions.push(newTransaction)
        this.loading = false
        console.log('Transaction created:', newTransaction)
        return newTransaction
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Update transaction
    async updateTransaction(id, transactionData) {
      this.loading = true
      this.error = null
      
      try {
        // Mock implementation - replace with actual API call
        const index = this.transactions.findIndex(t => t.id === parseInt(id))
        if (index !== -1) {
          this.transactions[index] = { ...this.transactions[index], ...transactionData }
          this.loading = false
          return this.transactions[index]
        } else {
          throw new Error('Transaction not found')
        }
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Delete transaction
    async deleteTransaction(id) {
      this.loading = true
      this.error = null
      
      try {
        // Mock implementation - replace with actual API call
        const index = this.transactions.findIndex(t => t.id === parseInt(id))
        if (index !== -1) {
          this.transactions.splice(index, 1)
          this.loading = false
          console.log('Transaction deleted:', id)
        } else {
          throw new Error('Transaction not found')
        }
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Clear error
    clearError() {
      this.error = null
    }
  }
})
