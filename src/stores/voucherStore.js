import { defineStore } from 'pinia'
import { voucherService } from '../services/voucherService'

export const useVoucherStore = defineStore('voucher', {
  state: () => ({
    vouchers: [],
    currentVoucher: null,
    loading: false,
    error: null
  }),

  getters: {
    getVoucherById: (state) => (id) => {
      return state.vouchers.find(voucher => voucher.id === id)
    },
    totalVouchers: (state) => state.vouchers.length,
    activeVouchers: (state) => state.vouchers.filter(voucher => voucher.status === 'active')
  },

  actions: {
    // Fetch all vouchers
    async fetchVouchers() {
      this.loading = true
      this.error = null
      
      try {
        console.log('Fetching vouchers from API...')
        const response = await voucherService.getVouchers()
        console.log('Raw API response:', response)
        
        // Handle different response structures
        let vouchersData = response.data || response || []
        
        // If the response has a nested data property (like your Postman response)
        if (response.data && Array.isArray(response.data.data)) {
          vouchersData = response.data.data
        } else if (response.data && Array.isArray(response.data)) {
          vouchersData = response.data
        } else if (Array.isArray(response)) {
          vouchersData = response
        }
        
        this.vouchers = vouchersData
        console.log('Vouchers processed and stored:', this.vouchers.length, this.vouchers)
        this.loading = false
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.error('Failed to fetch vouchers from API:', error.message)
        console.error('Full error:', error)
        
        // Fallback data for development - hapus ini jika tidak perlu
        this.vouchers = []
        console.log('Using empty fallback voucher array')
      }
    },

    // Fetch single voucher
    async fetchVoucher(id) {
      this.loading = true
      this.error = null
      
      try {
        const response = await voucherService.getVoucher(id)
        this.currentVoucher = response.data || response
        this.loading = false
        return this.currentVoucher
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Create new voucher
    async createVoucher(voucherData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await voucherService.createVoucher(voucherData)
        const newVoucher = response.data || response
        
        // Add to local state
        this.vouchers.unshift(newVoucher)
        this.loading = false
        console.log('Voucher created successfully:', newVoucher)
        return newVoucher
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.error('Failed to create voucher:', error.message)
        throw error
      }
    },

    // Update voucher
    async updateVoucher(id, voucherData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await voucherService.updateVoucher(id, voucherData)
        const updatedVoucher = response.data || response
        
        // Update in local state
        const index = this.vouchers.findIndex(voucher => voucher.id === parseInt(id))
        if (index !== -1) {
          this.vouchers[index] = updatedVoucher
        }
        
        this.loading = false
        console.log('Voucher updated successfully:', updatedVoucher)
        return updatedVoucher
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.error('Failed to update voucher:', error.message)
        throw error
      }
    },

    // Delete voucher
    async deleteVoucher(id) {
      this.loading = true
      this.error = null
      
      try {
        await voucherService.deleteVoucher(id)
        
        // Remove from local state
        this.vouchers = this.vouchers.filter(voucher => voucher.id !== parseInt(id))
        this.loading = false
        console.log('Voucher deleted successfully')
      } catch (error) {
        this.error = error.message
        this.loading = false
        console.error('Failed to delete voucher:', error.message)
        throw error
      }
    },

    // Clear error
    clearError() {
      this.error = null
    },

    // Clear current voucher
    clearCurrentVoucher() {
      this.currentVoucher = null
    }
  }
})
