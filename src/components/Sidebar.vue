<script setup>
import { ref, computed } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import { useAuthStore } from '../stores/authStore';
import { authService } from '../services/authService';

const route = useRoute();
const authStore = useAuthStore();
const isSidebarCollapsed = ref(false);

// Navigation items for authenticated users
const adminNavItems = [
  { 
    path: '/dashboard', 
    label: 'Dashboard',
    icon: 'fas fa-tachometer-alt'
  },
  { 
    path: '/customers', 
    label: 'Customers',
    icon: 'fas fa-users'
  },
  { 
    path: '/branches', 
    label: 'Branches',
    icon: 'fas fa-map-marker-alt'
  },
  { 
    path: '/services-management', 
    label: 'Services',
    icon: 'fas fa-cogs'
  },
  { 
    path: '/vouchers', 
    label: 'Vouchers',
    icon: 'fas fa-ticket-alt'
  },
  { 
    path: '/transactions', 
    label: 'Transactions',
    icon: 'fas fa-receipt'
  },
  { 
    path: '/settings', 
    label: 'Settings',
    icon: 'fas fa-cog'
  }
];

const userNavItems = [
  { 
    path: '/dashboard', 
    label: 'Dashboard',
    icon: 'fas fa-tachometer-alt'
  },
  { 
    path: '/services-management', 
    label: 'Services',
    icon: 'fas fa-cogs'
  },
  { 
    path: '/transactions', 
    label: 'Transaksi Saya',
    icon: 'fas fa-receipt'
  },
  { 
    path: '/vouchers', 
    label: 'Voucher',
    icon: 'fas fa-ticket-alt'
  }
];

// Computed property to get current nav items based on user role
const navItems = computed(() => {
  if (authService.isAdmin()) {
    return adminNavItems;
  } else if (authService.isUser()) {
    return userNavItems;
  }
  return [];
});

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};
</script>

<template>
  <div 
    class="fixed left-0 top-0 h-full bg-white shadow-lg transition-all duration-300 z-40"
    :class="[isSidebarCollapsed ? 'w-16' : 'w-64']"
  >
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 border-b border-gray-200">
      <RouterLink 
        v-if="!isSidebarCollapsed" 
        to="/" 
        class="flex items-center group"
      >
        <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white mr-3 transition-transform duration-300 group-hover:scale-110">
          <i class="fas fa-tshirt text-sm"></i>
        </div>
        <span class="text-lg font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">
          LaundrEase
        </span>
      </RouterLink>
      
      <button 
        @click="toggleSidebar"
        class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
        :class="[isSidebarCollapsed ? 'mx-auto' : '']"
      >
        <i class="fas fa-bars text-gray-600"></i>
      </button>
    </div>

    <!-- User Info -->
    <div class="p-4 border-b border-gray-200">
      <div 
        :class="[
          'flex items-center',
          isSidebarCollapsed ? 'justify-center' : ''
        ]"
      >
        <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-medium">
          {{ authStore.currentUser?.name?.charAt(0) || 'U' }}
        </div>
        <div v-if="!isSidebarCollapsed" class="ml-3">
          <div class="text-sm font-medium text-gray-900">
            {{ authStore.currentUser?.name || 'User' }}
          </div>
          <div class="text-xs text-gray-500">
            {{ authService.getUserRole() || 'guest' }}
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-4 px-2">
      <div class="space-y-1">
        <RouterLink
          v-for="item in navItems"
          :key="item.path"
          :to="item.path"
          class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group"
          :class="[
            route.path === item.path
              ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600'
              : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
          ]"
        >
          <i 
            :class="[
              item.icon,
              'text-lg',
              isSidebarCollapsed ? 'mx-auto' : 'mr-3',
              route.path === item.path ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-600'
            ]"
          ></i>
          <span v-if="!isSidebarCollapsed" class="truncate">
            {{ item.label }}
          </span>
        </RouterLink>
      </div>
    </nav>

    <!-- Footer Actions -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
      <div class="space-y-2">
        <RouterLink
          to="/profile"
          class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-all duration-200"
          :class="[isSidebarCollapsed ? 'justify-center' : '']"
        >
          <i 
            :class="[
              'fas fa-user text-gray-400',
              isSidebarCollapsed ? '' : 'mr-3'
            ]"
          ></i>
          <span v-if="!isSidebarCollapsed">Profile</span>
        </RouterLink>
        
        <button
          @click="$emit('logout')"
          class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 hover:text-red-700 transition-all duration-200"
          :class="[isSidebarCollapsed ? 'justify-center' : '']"
        >
          <i 
            :class="[
              'fas fa-sign-out-alt text-red-400',
              isSidebarCollapsed ? '' : 'mr-3'
            ]"
          ></i>
          <span v-if="!isSidebarCollapsed">Sign out</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Sidebar Overlay for mobile -->
  <div 
    v-if="!isSidebarCollapsed"
    class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
    @click="toggleSidebar"
  ></div>
</template>

<style scoped>
/* Custom scrollbar for sidebar */
nav::-webkit-scrollbar {
  width: 4px;
}

nav::-webkit-scrollbar-track {
  background: #f1f1f1;
}

nav::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 2px;
}

nav::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
