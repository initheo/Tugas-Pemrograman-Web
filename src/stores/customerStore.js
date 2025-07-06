import { defineStore } from 'pinia'
import { customerService } from '../services/customerService'

export const useCustomerStore = defineStore('customer', {
  state: () => ({
    customers: [],
    currentCustomer: null,
    loading: false,
    error: null
  }),

  getters: {
    getCustomerById: (state) => (id) => {
      return state.customers.find(customer => customer.id === id)
    },
    totalCustomers: (state) => state.customers.length
  },

  actions: {
    // Fetch all customers
    async fetchCustomers() {
      this.loading = true
      this.error = null
      
      try {
        const response = await customerService.getCustomers()
        this.customers = response.data || response
        this.loading = false
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Fetch single customer
    async fetchCustomer(id) {
      this.loading = true
      this.error = null
      
      try {
        const response = await customerService.getCustomer(id)
        this.currentCustomer = response.data || response
        this.loading = false
        return this.currentCustomer
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Create new customer
    async createCustomer(customerData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await customerService.createCustomer(customerData)
        const newCustomer = response.data || response
        this.customers.push(newCustomer)
        this.loading = false
        return newCustomer
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Update customer
    async updateCustomer(id, customerData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await customerService.updateCustomer(id, customerData)
        const updatedCustomer = response.data || response
        
        const index = this.customers.findIndex(customer => customer.id === id)
        if (index !== -1) {
          this.customers[index] = updatedCustomer
        }
        
        this.loading = false
        return updatedCustomer
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Delete customer
    async deleteCustomer(id) {
      this.loading = true
      this.error = null
      
      try {
        await customerService.deleteCustomer(id)
        this.customers = this.customers.filter(customer => customer.id !== id)
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

    // Clear current customer
    clearCurrentCustomer() {
      this.currentCustomer = null
    }
  }
})
