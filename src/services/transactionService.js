import api from './api'

export const transactionService = {
  // Get all transactions
  async getTransactions() {
    try {
      const response = await api.get('/transactions')
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch transactions')
    }
  },

  // Get single transaction by ID
  async getTransaction(id) {
    try {
      const response = await api.get(`/transactions/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch transaction')
    }
  },

  // Create new transaction
  async createTransaction(transactionData) {
    try {
      const response = await api.post('/transactions', transactionData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to create transaction')
    }
  },

  // Delete transaction
  async deleteTransaction(id) {
    try {
      const response = await api.delete(`/transactions/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to delete transaction')
    }
  },

  // Check payment status
  async checkPaymentStatus(id) {
    try {
      const response = await api.get(`/transactions/${id}/payment-status`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to check payment status')
    }
  }
}
