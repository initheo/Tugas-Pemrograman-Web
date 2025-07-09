import api from './api'

export const authService = {
  // Login user (tidak perlu CSRF cookie untuk API token-based auth)
  async login(credentials) {
    try {
      console.log('AuthService: Sending login request to backend')
      const response = await api.post('/login', credentials)
      
      console.log('AuthService: Login response received:', response.data)
      
      // Menyesuaikan dengan struktur response Laravel Sanctum dari contoh
      if (response.data['access-token']) {
        localStorage.setItem('auth_token', response.data['access-token'])
        localStorage.setItem('user', JSON.stringify(response.data.data))
        console.log('AuthService: Token and user data stored in localStorage')
        
        return {
          token: response.data['access-token'],
          user: response.data.data
        }
      }
      
      // Fallback untuk struktur response yang lama
      if (response.data.token) {
        localStorage.setItem('auth_token', response.data.token)
        localStorage.setItem('user', JSON.stringify(response.data.user))
        console.log('AuthService: Token and user data stored in localStorage')
      }
      
      return response.data
    } catch (error) {
      console.error('AuthService: Login failed:', error.response?.data || error.message)
      throw new Error(error.response?.data?.message || 'Login failed')
    }
  },

  // Logout user
  async logout() {
    try {
      await api.post('/logout')
      localStorage.removeItem('auth_token')
      localStorage.removeItem('user')
    } catch (error) {
      // Even if logout fails on server, clear local storage
      localStorage.removeItem('auth_token')
      localStorage.removeItem('user')
    }
  },

  // Get current user
  getCurrentUser() {
    const user = localStorage.getItem('user')
    return user ? JSON.parse(user) : null
  },

  // Check if user is authenticated
  isAuthenticated() {
    const token = localStorage.getItem('auth_token')
    const user = localStorage.getItem('user')
    console.log('AuthService: Checking authentication:', { token: !!token, user: !!user })
    return !!(token && user)
  },

  // Check if current user is admin
  isAdmin() {
    const user = this.getCurrentUser()
    return user && user.role === 'admin'
  },

  // Check if current user is regular user
  isUser() {
    const user = this.getCurrentUser()
    return user && user.role === 'user'
  },

  // Get user role
  getUserRole() {
    const user = this.getCurrentUser()
    return user ? user.role : null
  },

  // Update user profile
  async updateProfile(profileData) {
    try {
      console.log('AuthService: Sending profile update request to backend')
      const response = await api.put('/profile', profileData)
      
      console.log('AuthService: Profile update response received:', response.data)
      
      // Update localStorage with new user data
      if (response.data.user || response.data.data) {
        const userData = response.data.user || response.data.data
        localStorage.setItem('user', JSON.stringify(userData))
        console.log('AuthService: User data updated in localStorage')
      }
      
      return response.data
    } catch (error) {
      console.error('AuthService: Profile update failed:', error.response?.data || error.message)
      throw new Error(error.response?.data?.message || 'Failed to update profile')
    }
  },

  // Change user password
  async changePassword(passwordData) {
    try {
      console.log('AuthService: Sending password change request to backend')
      const response = await api.put('/change-password', passwordData)
      
      console.log('AuthService: Password change response received:', response.data)
      
      return response.data
    } catch (error) {
      console.error('AuthService: Password change failed:', error.response?.data || error.message)
      
      // Handle validation errors specifically
      if (error.response?.status === 422 && error.response?.data?.errors) {
        const validationErrors = error.response.data.errors
        if (validationErrors.current_password) {
          throw new Error(validationErrors.current_password[0])
        }
        if (validationErrors.new_password) {
          throw new Error(validationErrors.new_password[0])
        }
      }
      
      throw new Error(error.response?.data?.message || 'Failed to change password')
    }
  }
}
