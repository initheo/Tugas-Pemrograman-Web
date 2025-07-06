// Debug utility for authentication issues
export const debugAuth = () => {
  const token = localStorage.getItem('auth_token')
  const user = localStorage.getItem('user')
  
  console.log('=== AUTH DEBUG ===')
  console.log('Token exists:', !!token)
  console.log('Token value:', token ? token.substring(0, 20) + '...' : 'null')
  console.log('User exists:', !!user)
  
  if (user) {
    try {
      const parsedUser = JSON.parse(user)
      console.log('User data:', parsedUser)
    } catch (error) {
      console.log('Error parsing user data:', error)
    }
  }
  
  console.log('==================')
}

// Clear all auth data (for debugging)
export const clearAuthDebug = () => {
  localStorage.removeItem('auth_token')
  localStorage.removeItem('user')
  console.log('Auth data cleared')
  window.location.reload()
}

// Make debug functions available globally for easy access
if (typeof window !== 'undefined') {
  window.debugAuth = debugAuth
  window.clearAuthDebug = clearAuthDebug
}
