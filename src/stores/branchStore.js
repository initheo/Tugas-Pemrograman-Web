import { defineStore } from 'pinia'
import { branchService } from '../services/branchService'

export const useBranchStore = defineStore('branch', {
  state: () => ({
    branches: [],
    currentBranch: null,
    loading: false,
    error: null
  }),

  getters: {
    getBranchById: (state) => (id) => {
      return state.branches.find(branch => branch.id === id)
    },
    totalBranches: (state) => state.branches.length
  },

  actions: {
    // Fetch all branch stores
    async fetchBranches() {
      this.loading = true
      this.error = null
      
      try {
        const response = await branchService.getBranchStores()
        this.branches = response.data || response || []
        this.loading = false
      } catch (error) {
        this.error = error.message
        this.branches = [] // Pastikan branches tetap array meskipun ada error
        this.loading = false
        console.warn('Failed to fetch branches, setting empty array')
        throw error
      }
    },

    // Fetch single branch store
    async fetchBranch(id) {
      this.loading = true
      this.error = null
      
      try {
        const response = await branchService.getBranchStore(id)
        this.currentBranch = response.data || response
        this.loading = false
        return this.currentBranch
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Create new branch store
    async createBranch(branchData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await branchService.createBranchStore(branchData)
        const newBranch = response.data || response
        this.branches.push(newBranch)
        this.loading = false
        return newBranch
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Update branch store
    async updateBranch(id, branchData) {
      this.loading = true
      this.error = null
      
      try {
        const response = await branchService.updateBranchStore(id, branchData)
        const updatedBranch = response.data || response
        
        const index = this.branches.findIndex(branch => branch.id === id)
        if (index !== -1) {
          this.branches[index] = updatedBranch
        }
        
        this.loading = false
        return updatedBranch
      } catch (error) {
        this.error = error.message
        this.loading = false
        throw error
      }
    },

    // Delete branch store
    async deleteBranch(id) {
      this.loading = true
      this.error = null
      
      try {
        await branchService.deleteBranchStore(id)
        this.branches = this.branches.filter(branch => branch.id !== id)
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

    // Clear current branch
    clearCurrentBranch() {
      this.currentBranch = null
    }
  }
})
