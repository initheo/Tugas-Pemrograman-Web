import api from './api'

export const customerService = {
  // Get all customers
  async getCustomers() {
    try {
      const response = await api.get('/customers')
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch customers')
    }
  },

  // Get single customer by ID
  async getCustomer(id) {
    try {
      const response = await api.get(`/customers/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch customer')
    }
  },

  // Create new customer
  async createCustomer(customerData) {
    try {
      const response = await api.post('/customers', customerData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to create customer')
    }
  },

  // Update customer
  async updateCustomer(id, customerData) {
    try {
      const response = await api.put(`/customers/${id}`, customerData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to update customer')
    }
  },

  // Delete customer
  async deleteCustomer(id) {
    try {
      const response = await api.delete(`/customers/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to delete customer')
    }
  }
}
