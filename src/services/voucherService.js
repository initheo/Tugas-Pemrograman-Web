import api from './api'

export const voucherService = {
  // Get all vouchers
  async getVouchers() {
    try {
      const response = await api.get('/vouchers')
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch vouchers')
    }
  },

  // Get single voucher by ID
  async getVoucher(id) {
    try {
      const response = await api.get(`/vouchers/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch voucher')
    }
  },

  // Create new voucher
  async createVoucher(voucherData) {
    try {
      const response = await api.post('/vouchers', voucherData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to create voucher')
    }
  },

  // Update voucher
  async updateVoucher(id, voucherData) {
    try {
      const response = await api.put(`/vouchers/${id}`, voucherData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to update voucher')
    }
  },

  // Delete voucher
  async deleteVoucher(id) {
    try {
      const response = await api.delete(`/vouchers/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to delete voucher')
    }
  }
}
