import { defineStore } from 'pinia'
import { authService } from '../services/authService'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    isAuthenticated: false,
    loading: false,
    error: null
  }),

  getters: {
    currentUser: (state) => state.user,
    isLoggedIn: (state) => state.isAuthenticated
  },

  actions: {
    // Initialize auth state from localStorage
    initializeAuth() {
      const token = localStorage.getItem('auth_token')
      const user = localStorage.getItem('user')
      
      console.log('Initializing auth state...', { token: !!token, user: !!user })
      
      if (token && user) {
        try {
          this.token = token
          this.user = JSON.parse(user)
          this.isAuthenticated = true
          console.log('Auth state initialized successfully:', this.user)
        } catch (error) {
          console.error('Error parsing user data:', error)
          this.clearAuthData()
        }
      } else {
        this.clearAuthData()
      }
    },

    // Clear auth data
    clearAuthData() {
      this.user = null
      this.token = null
      this.isAuthenticated = false
      localStorage.removeItem('auth_token')
      localStorage.removeItem('user')
    },

    // Login action
    async login(credentials) {
      this.loading = true
      this.error = null
      
      try {
        console.log('Attempting login with:', credentials.email)
        const response = await authService.login(credentials)
        
        console.log('Login response:', response)
        
        // Handle response yang sesuai dengan Laravel Sanctum pattern
        if (response.user || response.data) {
          this.user = response.user || response.data
          this.token = response.token || response['access-token']
          this.isAuthenticated = true
        } else {
          // Fallback untuk struktur response lama
          this.user = response.user
          this.token = response.token
          this.isAuthenticated = true
        }
        
        this.loading = false
        
        console.log('Auth state after login:', {
          user: this.user,
          isAuthenticated: this.isAuthenticated
        })
        
        return response
      } catch (error) {
        console.error('Login error:', error)
        this.error = error.message
        this.loading = false
        this.clearAuthData()
        throw error
      }
    },

    // Logout action
    async logout() {
      this.loading = true
      
      try {
        await authService.logout()
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.clearAuthData()
        this.loading = false
      }
    },

    // Clear error
    clearError() {
      this.error = null
    }
  }
})
