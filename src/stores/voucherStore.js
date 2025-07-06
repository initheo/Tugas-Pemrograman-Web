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
        const response = await voucherService.getVouchers()
        this.vouchers = response.data || response || []
        this.loading = false
      } catch (error) {
        this.error = error.message
        this.vouchers = [] // Pastikan vouchers tetap array meskipun ada error
        this.loading = false
        console.warn('Failed to fetch vouchers, setting empty array')
        throw error
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
        this.vouchers.push(newVoucher)
        this.loading = false
        return newVoucher
      } catch (error) {
        this.error = error.message
        this.loading = false
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
        
        const index = this.vouchers.findIndex(voucher => voucher.id === id)
        if (index !== -1) {
          this.vouchers[index] = updatedVoucher
        }
        
        this.loading = false
        return updatedVoucher
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Delete voucher
    async deleteVoucher(id) {
      this.loading = true
      this.error = null
      
      try {
        await voucherService.deleteVoucher(id)
        this.vouchers = this.vouchers.filter(voucher => voucher.id !== id)
        this.loading = false
      } catch (error) {
        this.error = error.message
        this.loading = false
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
