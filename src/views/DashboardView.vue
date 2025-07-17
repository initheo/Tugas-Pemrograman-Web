<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../stores/authStore';
import DashboardLayout from '../components/DashboardLayout.vue';

const authStore = useAuthStore();

// Dashboard stats
const stats = ref({
  totalTransactions: 0,
  activeCustomers: 0,
  pendingOrders: 0,
  completedToday: 0
});

// Recent activities
const recentActivities = ref([]);

// Load dashboard data
const loadDashboardData = async () => {
  try {
    // TODO: Replace with actual API calls
    stats.value = {
      totalTransactions: 1248,
      activeCustomers: 89,
      pendingOrders: 23,
      completedToday: 45
    };
    
    recentActivities.value = [
      { id: 1, type: 'transaction', message: 'New transaction created', time: '2 minutes ago' },
      { id: 2, type: 'order', message: 'Order completed', time: '15 minutes ago' },
      { id: 3, type: 'customer', message: 'New customer registered', time: '1 hour ago' }
    ];
  } catch (error) {
    console.error('Error loading dashboard data:', error);
  }
};

onMounted(() => {
  loadDashboardData();
});
</script>

<template>
  <DashboardLayout title="Dashboard" :showBreadcrumb="false">
    <!-- Welcome Section -->
    <div class="mb-8">
      <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">
          Welcome back, {{ authStore.currentUser?.name || 'User' }}! 👋
        </h2>
        <p class="text-primary-100">
          Here's what's happening with your laundry business today.
        </p>
      </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Total Transactions -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Transactions</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.totalTransactions }}</p>
          </div>
          <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
            <i class="fas fa-receipt text-blue-600"></i>
          </div>
        </div>
        <div class="mt-4">
          <span class="text-sm text-green-600">↗ 12% from last month</span>
        </div>
      </div>

      <!-- Active Customers -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Active Customers</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.activeCustomers }}</p>
          </div>
          <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
            <i class="fas fa-users text-green-600"></i>
          </div>
        </div>
        <div class="mt-4">
          <span class="text-sm text-green-600">↗ 8% from last month</span>
        </div>
      </div>

      <!-- Pending Orders -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Pending Orders</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.pendingOrders }}</p>
          </div>
          <div class="h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center">
            <i class="fas fa-clock text-yellow-600"></i>
          </div>
        </div>
        <div class="mt-4">
          <span class="text-sm text-yellow-600">Needs attention</span>
        </div>
      </div>

      <!-- Completed Today -->
      <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Completed Today</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.completedToday }}</p>
          </div>
          <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
            <i class="fas fa-check-circle text-purple-600"></i>
          </div>
        </div>
        <div class="mt-4">
          <span class="text-sm text-green-600">Great job!</span>
        </div>
      </div>
    </div>

    <!-- Recent Activities and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Recent Activities -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
          </div>
          <div class="p-6">
            <div class="space-y-4">
              <div 
                v-for="activity in recentActivities" 
                :key="activity.id"
                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200"
              >
                <div class="h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center">
                  <i 
                    :class="[
                      activity.type === 'transaction' ? 'fas fa-receipt text-blue-600' :
                      activity.type === 'order' ? 'fas fa-check-circle text-green-600' :
                      'fas fa-user text-purple-600'
                    ]"
                  ></i>
                </div>
                <div class="flex-1">
                  <p class="text-sm text-gray-900">{{ activity.message }}</p>
                  <p class="text-xs text-gray-500">{{ activity.time }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
          </div>
          <div class="p-6">
            <div class="space-y-3">
              <RouterLink 
                to="/transactions"
                class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200"
              >
                <i class="fas fa-plus text-primary-600 mr-3"></i>
                <span class="text-sm font-medium text-gray-900">New Transaction</span>
              </RouterLink>
              
              <RouterLink 
                to="/customers"
                class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200"
              >
                <i class="fas fa-user-plus text-green-600 mr-3"></i>
                <span class="text-sm font-medium text-gray-900">Add Customer</span>
              </RouterLink>
              
              <RouterLink 
                to="/vouchers"
                class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200"
              >
                <i class="fas fa-ticket-alt text-purple-600 mr-3"></i>
                <span class="text-sm font-medium text-gray-900">Create Voucher</span>
              </RouterLink>
              
              <RouterLink 
                to="/settings"
                class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors duration-200"
              >
                <i class="fas fa-cog text-gray-600 mr-3"></i>
                <span class="text-sm font-medium text-gray-900">Settings</span>
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<style scoped>
/* Additional custom styles if needed */
</style>
