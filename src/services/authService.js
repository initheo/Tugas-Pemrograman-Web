import api from './api'

export const authService = {
  // Login user
  async login(credentials) {
    try {
      console.log('AuthService: Sending login request to backend')
      const response = await api.post('/login', credentials)
      
      console.log('AuthService: Login response received:', response.data)
      
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
  }
}
