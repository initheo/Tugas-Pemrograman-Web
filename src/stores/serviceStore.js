import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../services/api'

export const useServiceStore = defineStore('service', () => {
  const services = ref([])
  const loading = ref(false)
  const error = ref(null)

  // Get all services
  const fetchServices = async () => {
    loading.value = true
    error.value = null
    
    try {
      const response = await api.get('/services')
      services.value = response.data.data || response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch services'
      console.error('Error fetching services:', err)
    } finally {
      loading.value = false
    }
  }

  // Get single service
  const getService = async (id) => {
    loading.value = true
    error.value = null
    
    try {
      const response = await api.get(`/services/${id}`)
      return response.data.data || response.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch service'
      console.error('Error fetching service:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  // Create new service
  const createService = async (serviceData) => {
    loading.value = true
    error.value = null
    
    try {
      const response = await api.post('/services', serviceData)
      const newService = response.data.data || response.data
      services.value.push(newService)
      return newService
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to create service'
      console.error('Error creating service:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  // Update service
  const updateService = async (id, serviceData) => {
    loading.value = true
    error.value = null
    
    try {
      const response = await api.put(`/services/${id}`, serviceData)
      const updatedService = response.data.data || response.data
      
      // Update in local state
      const index = services.value.findIndex(service => service.id === id)
      if (index !== -1) {
        services.value[index] = updatedService
      }
      
      return updatedService
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to update service'
      console.error('Error updating service:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  // Delete service
  const deleteService = async (id) => {
    loading.value = true
    error.value = null
    
    try {
      await api.delete(`/services/${id}`)
      
      // Remove from local state
      services.value = services.value.filter(service => service.id !== id)
      return true
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to delete service'
      console.error('Error deleting service:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  // Toggle service status
  const toggleServiceStatus = async (id) => {
    const service = services.value.find(s => s.id === id)
    if (!service) return
    
    try {
      const updatedData = { ...service, is_active: !service.is_active }
      await updateService(id, updatedData)
    } catch (err) {
      console.error('Error toggling service status:', err)
      throw err
    }
  }

  // Get active services only
  const getActiveServices = () => {
    return services.value.filter(service => service.is_active)
  }

  // Search services
  const searchServices = (query) => {
    if (!query) return services.value
    
    const lowercaseQuery = query.toLowerCase()
    return services.value.filter(service => 
      service.name?.toLowerCase().includes(lowercaseQuery) ||
      service.description?.toLowerCase().includes(lowercaseQuery) ||
      service.service_code?.toLowerCase().includes(lowercaseQuery)
    )
  }

  return {
    services,
    loading,
    error,
    fetchServices,
    getService,
    createService,
    updateService,
    deleteService,
    toggleServiceStatus,
    getActiveServices,
    searchServices
  }
})
