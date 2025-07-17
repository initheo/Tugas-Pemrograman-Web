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
    isLoggedIn: (state) => state.isAuthenticated,
    isAdmin: (state) => state.user?.role === 'admin',
    isUser: (state) => state.user?.role === 'user',
    getCurrentUser: (state) => () => state.user
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
        if (response.user && response.token) {
          this.user = response.user
          this.token = response.token
          this.isAuthenticated = true
        } else if (response.data && response['access-token']) {
          // Response dari repo referensi
          this.user = response.data
          this.token = response['access-token']
          this.isAuthenticated = true
        } else {
          // Fallback untuk struktur response lama
          this.user = response.user || response.data
          this.token = response.token || response['access-token']
          this.isAuthenticated = true
        }
        
        this.loading = false
        
        console.log('Auth state after login:', {
          user: this.user,
          isAuthenticated: this.isAuthenticated
        })
        
        return { success: true, data: response }
      } catch (error) {
        console.error('Login error:', error)
        this.error = error.message
        this.loading = false
        this.clearAuthData()
        return { success: false, error: error.message }
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
    },

    // Update profile
    async updateProfile(profileData) {
      this.loading = true
      this.error = null
      
      try {
        console.log('Updating profile with:', profileData)
        const response = await authService.updateProfile(profileData)
        
        console.log('Profile update response:', response)
        
        // Update user data in store
        if (response.user || response.data) {
          this.user = response.user || response.data
          // Update localStorage
          localStorage.setItem('user', JSON.stringify(this.user))
          console.log('Profile updated successfully:', this.user)
        }
        
        this.loading = false
        return { success: true, data: response }
      } catch (error) {
        console.error('Profile update error:', error)
        this.error = error.message
        this.loading = false
        return { success: false, error: error.message }
      }
    },

    // Change password
    async changePassword(passwordData) {
      this.loading = true
      this.error = null
      
      try {
        console.log('Changing password...')
        const response = await authService.changePassword(passwordData)
        
        console.log('Password change response:', response)
        
        this.loading = false
        return { success: true, data: response }
      } catch (error) {
        console.error('Password change error:', error)
        this.error = error.message
        this.loading = false
        return { success: false, error: error.message }
      }
    },

    // Register action
    async register(registrationData) {
      this.loading = true
      this.error = null
      
      try {
        console.log('Attempting registration with:', registrationData.email)
        const response = await authService.register(registrationData)
        
        console.log('Registration response:', response)
        
        // Handle response yang sesuai dengan Laravel Sanctum pattern
        if (response.user && response.token) {
          this.user = response.user
          this.token = response.token
          this.isAuthenticated = true
        } else if (response.data && response['access-token']) {
          // Response dari repo referensi
          this.user = response.data
          this.token = response['access-token']
          this.isAuthenticated = true
        } else {
          // Fallback untuk struktur response lama
          this.user = response.user || response.data
          this.token = response.token || response['access-token']
          this.isAuthenticated = true
        }
        
        // Simpan ke localStorage setelah registrasi berhasil
        if (this.token) {
          localStorage.setItem('auth_token', this.token)
        }
        if (this.user) {
          localStorage.setItem('user', JSON.stringify(this.user))
        }
        
        this.loading = false
        
        console.log('Auth state after registration:', {
          user: this.user,
          isAuthenticated: this.isAuthenticated
        })
        
        return { success: true, data: response }
      } catch (error) {
        console.error('Registration error:', error)
        this.error = error.message
        this.loading = false
        this.clearAuthData()
        return { success: false, error: error.message }
      }
    }
  }
})
