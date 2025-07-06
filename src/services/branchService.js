import api from './api'

export const branchService = {
  // Get all branch stores
  async getBranchStores() {
    try {
      const response = await api.get('/branchstores')
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch branch stores')
    }
  },

  // Get single branch store by ID
  async getBranchStore(id) {
    try {
      const response = await api.get(`/branchstores/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch branch store')
    }
  },

  // Create new branch store
  async createBranchStore(branchData) {
    try {
      const response = await api.post('/branchstores', branchData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to create branch store')
    }
  },

  // Update branch store
  async updateBranchStore(id, branchData) {
    try {
      const response = await api.put(`/branchstores/${id}`, branchData)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to update branch store')
    }
  },

  // Delete branch store
  async deleteBranchStore(id) {
    try {
      const response = await api.delete(`/branchstores/${id}`)
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to delete branch store')
    }
  }
}
