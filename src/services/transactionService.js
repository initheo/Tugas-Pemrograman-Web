import api from './api'

export const transactionService = {
  // Get all transactions
  async getTransactions() {
    try {
      const response = await api.get('/transactions')
      return response.data
    } catch (error) {
      console.error('Error fetching transactions:', error)
      throw new Error(error.response?.data?.message || 'Failed to fetch transactions')
    }
  },

  // Get single transaction by ID
  async getTransaction(id) {
    try {
      const response = await api.get(`/transactions/${id}`)
      return response.data
    } catch (error) {
      console.error('Error fetching transaction:', error)
      throw new Error(error.response?.data?.message || 'Failed to fetch transaction')
    }
  },

  // Create new transaction
  async createTransaction(transactionData) {
    try {
      const response = await api.post('/transactions', transactionData)
      return response.data
    } catch (error) {
      console.error('Error creating transaction:', error)
      throw new Error(error.response?.data?.message || 'Failed to create transaction')
    }
  },

  // Delete transaction
  async deleteTransaction(id) {
    try {
      const response = await api.delete(`/transactions/${id}`)
      return response.data
    } catch (error) {
      console.error('Error deleting transaction:', error)
      throw new Error(error.response?.data?.message || 'Failed to delete transaction')
    }
  },

  // Check payment status
  async checkPaymentStatus(id) {
    try {
      const response = await api.get(`/transactions/${id}/payment-status`)
      return response.data
    } catch (error) {
      console.error('Error checking payment status:', error)
      throw new Error(error.response?.data?.message || 'Failed to check payment status')
    }
  },

  // Handle payment callback (for webhook)
  async handlePaymentCallback(callbackData) {
    try {
      const response = await api.post('/payment/callback', callbackData)
      return response.data
    } catch (error) {
      console.error('Error handling payment callback:', error)
      throw new Error(error.response?.data?.message || 'Failed to handle payment callback')
    }
  },

  // Update laundry status
  async updateLaundryStatus(id, status) {
    try {
      const response = await api.patch(`/transactions/${id}/laundry-status`, {
        status_laundry: status
      })
      return response.data
    } catch (error) {
      console.error('Error updating laundry status:', error)
      throw new Error(error.response?.data?.message || 'Failed to update laundry status')
    }
  },

  // Refresh transaction data
  async refreshTransaction(id) {
    try {
      const response = await api.get(`/transactions/${id}/refresh`)
      return response.data
    } catch (error) {
      console.error('Error refreshing transaction:', error)
      // Fallback to regular get if refresh endpoint doesn't exist
      return this.getTransaction(id)
    }
  },

  // Download invoice
  async downloadInvoice(id) {
    try {
      const response = await api.get(`/transactions/${id}/download-invoice`, {
        responseType: 'blob', // Important untuk file download
        headers: {
          'Accept': 'application/pdf'
        }
      })
      return response
    } catch (error) {
      console.error('Error downloading invoice:', error)
      throw new Error(error.response?.data?.message || 'Failed to download invoice')
    }
  }
}
