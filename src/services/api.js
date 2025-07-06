import axios from 'axios'

// Base URL for the Laravel API
// Dalam development, gunakan proxy melalui vite config
// Dalam production, bisa diganti ke URL absolute
const API_BASE_URL = import.meta.env.DEV ? '/api' : 'http://127.0.0.1:8000/api'

// Create axios instance with default configuration
const api = axios.create({
  baseURL: API_BASE_URL,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  },
  withCredentials: true, // Important for Sanctum
})

// Request interceptor to add auth token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    
    console.log('API Request:', config.method?.toUpperCase(), config.url, {
      headers: config.headers,
      hasToken: !!token
    })
    return config
  },
  (error) => {
    console.error('API Request Error:', error)
    return Promise.reject(error)
  }
)

// Response interceptor to handle errors globally
api.interceptors.response.use(
  (response) => {
    console.log('API Response:', response.status, response.config.url, response.data)
    return response
  },
  (error) => {
    console.error('API Response Error:', {
      status: error.response?.status,
      url: error.response?.config?.url,
      data: error.response?.data
    })
    
    if (error.response?.status === 401) {
      // Token expired or invalid
      console.log('Unauthorized - clearing auth data')
      localStorage.removeItem('auth_token')
      localStorage.removeItem('user')
      
      // Hanya redirect jika bukan di halaman login
      if (!window.location.pathname.includes('/login')) {
        window.location.href = '/login'
      }
    }
    
    return Promise.reject(error)
  }
)

export default api
