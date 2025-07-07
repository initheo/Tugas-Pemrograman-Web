import api from './api'

export const dashboardService = {
  // Get dashboard data menggunakan endpoint yang sudah dibuat
  async getDashboardData() {
    try {
      const response = await api.get('/dashboard')
      // Response structure: { total_customers, total_branches, active_vouchers, best_customers, best_branches }
      return response.data
    } catch (error) {
      throw new Error(error.response?.data?.message || 'Failed to fetch dashboard data')
    }
  }
}
