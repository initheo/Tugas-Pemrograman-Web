<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';
import { authService } from '../services/authService';

defineProps({
  msg: String,
})

const router = useRouter();
const authStore = useAuthStore();
const isMobileMenuOpen = ref(false);
const showUserMenu = ref(false);

// Add navigation items array for public pages
const publicNavItems = [
  { path: '/', label: 'Beranda' },
  { path: '/about', label: 'Tentang Kami' },
  { path: '/services', label: 'Layanan' },
  { path: '/pricing', label: 'Harga' },
  { path: '/faq', label: 'FAQ' },
  { path: '/contact', label: 'Kontak' }
];

// Navigation items for authenticated users
const adminNavItems = [
  { path: '/dashboard', label: 'Dashboard' },
  { path: '/customers', label: 'Customers' },
  { path: '/branches', label: 'Branches' },
  { path: '/vouchers', label: 'Vouchers' },
  { path: '/transactions', label: 'Transactions' },
  { path: '/settings', label: 'Settings' }
];

const userNavItems = [
  { path: '/dashboard', label: 'Dashboard' },
  { path: '/transactions', label: 'Transaksi Saya' },
  { path: '/vouchers', label: 'Voucher' }
];

// Computed property to get current nav items based on auth status and role
const navItems = computed(() => {
  if (!authStore.isAuthenticated) {
    return publicNavItems;
  }
  
  if (authService.isAdmin()) {
    return adminNavItems;
  } else if (authService.isUser()) {
    return userNavItems;
  }
  
  return publicNavItems;
});

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value;
};

const handleLogout = async () => {
  try {
    await authStore.logout();
    router.push('/');
    showUserMenu.value = false;
  } catch (error) {
    console.error('Logout error:', error);
  }
};

// Close user menu when clicking outside
const handleClickOutside = (event) => {
  if (!event.target.closest('.relative')) {
    showUserMenu.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  // Ensure auth state is initialized
  if (!authStore.isAuthenticated) {
    authStore.initializeAuth();
  }
});

// Watch for authentication changes
watch(
  () => authStore.isAuthenticated,
  (newVal, oldVal) => {
    console.log('Header: Auth state changed', { newVal, oldVal, user: authStore.currentUser });
  }
);

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <!-- Header/Navigation -->
    <header
      ref="header"
      className="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm transition-all duration-300"
    >
      <div className="container mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16 md:h-20">
          
          <div className="flex items-center">
            <RouterLink to="/" className="flex items-center group">
              <div className="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white mr-3 transition-transform duration-300 group-hover:scale-110">
                <i className="fas fa-tshirt"></i>
              </div>
              <span className="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent">LaundrEase</span>
            </RouterLink>
          </div>

          <!-- Desktop Navigation -->
          <nav className="hidden md:flex space-x-1 lg:space-x-2">
            <RouterLink v-for="item in navItems" :key="item.path" :to="item.path" class="px-3 py-2 font-medium transition-all duration-300 rounded-md" :class="[$route.path === item.path ? 'bg-primary-50 text-primary-600' : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50']">
              {{ item.label }}
            </RouterLink>
          </nav>

          <!-- Authentication Section -->
          <div className="hidden md:flex items-center space-x-3">
            <!-- Show login/register for non-authenticated users -->
            <template v-if="!authStore.isAuthenticated">
              <RouterLink to="/login"
                className="px-4 py-2 text-secondary-600 hover:text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-all duration-300"
                >Login</RouterLink> 
            </template>

            <!-- Show user profile for authenticated users -->
            <template v-else>
              <div class="relative">
                <button
                  @click="toggleUserMenu"
                  class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 px-3 py-2 transition-all duration-300"
                >
                  <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center mr-2">
                    <span class="text-white text-sm font-medium">
                      {{ authStore.currentUser?.name?.charAt(0) || 'U' }}
                    </span>
                  </div>
                  <span class="text-gray-700 font-medium">{{ authStore.currentUser?.name || 'User' }}</span>
                  <i class="fas fa-chevron-down ml-2 text-xs text-gray-500"></i>
                </button>
                
                <!-- User Dropdown menu -->
                <Transition name="fade">
                  <div
                    v-if="showUserMenu"
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                  >
                    <div class="py-1">
                      <RouterLink
                        to="/profile"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                        @click="showUserMenu = false"
                      >
                        <i class="fas fa-user mr-2"></i>Profile
                      </RouterLink>
                      <RouterLink
                        v-if="authService.isAdmin()"
                        to="/settings"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200"
                        @click="showUserMenu = false"
                      >
                        <i class="fas fa-cog mr-2"></i>Settings
                      </RouterLink>
                      <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">
                        Role: {{ authService.getUserRole() || 'guest' }}
                      </div>
                      <hr class="my-1">
                      <button
                        @click="handleLogout"
                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200"
                      >
                        <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                      </button>
                    </div>
                  </div>
                </Transition>
              </div>
            </template>
          </div>

          <!-- Mobile menu button -->
          <div className="md:hidden">
            <button
              @click="toggleMobileMenu"
              className="text-secondary-600 hover:text-primary-600 p-2 rounded-md hover:bg-primary-50 transition-all duration-300"
              aria-label="Toggle menu"
            >
              <i className="fas fa-bars text-xl"></i>
            </button>
          </div>
        </div>

        <!-- Mobile Navigation -->
        <Transition name="slide-fade">
          <div 
            id="mobile-menu" 
            v-show="isMobileMenuOpen"
            className="md:hidden pb-6"
          >
            <nav className="flex flex-col space-y-1 mt-2">
              <RouterLink
                v-for="item in navItems"
                :key="item.path"
                :to="item.path"
                class="px-4 py-3 font-medium transition-all duration-300 rounded-md"
                :class="[
                  $route.path === item.path
                    ? 'bg-primary-50 text-primary-600'
                    : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'
                ]"
                @click="isMobileMenuOpen = false"
              >
                {{ item.label }}
              </RouterLink>
            </nav>
            
            <!-- Mobile Authentication Section -->
            <div className="flex flex-col space-y-3 mt-4 pt-4 border-t border-secondary-100 px-4">
              <!-- Show login/register for non-authenticated users -->
              <template v-if="!authStore.isAuthenticated">
                <RouterLink to="/login"
                  className="text-secondary-600 hover:text-primary-600 font-medium py-2 px-4 rounded-md hover:bg-primary-50 transition-all duration-300 text-center"
                  @click="isMobileMenuOpen = false"
                  >Login</RouterLink>

                <RouterLink to="/register"
                  className="bg-primary-600 text-white py-3 px-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 text-center"
                  @click="isMobileMenuOpen = false"
                  >Sign Up</RouterLink>
              </template>

              <!-- Show user profile options for authenticated users -->
              <template v-else>
                <div class="text-center py-2 px-4 bg-primary-50 rounded-md">
                  <div class="flex items-center justify-center mb-2">
                    <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center mr-3">
                      <span class="text-white font-medium">
                        {{ authStore.currentUser?.name?.charAt(0) || 'U' }}
                      </span>
                    </div>
                    <span class="text-gray-700 font-medium">{{ authStore.currentUser?.name || 'User' }}</span>
                  </div>
                </div>
                
                <RouterLink to="/profile"
                  className="text-secondary-600 hover:text-primary-600 font-medium py-2 px-4 rounded-md hover:bg-primary-50 transition-all duration-300 text-center flex items-center justify-center"
                  @click="isMobileMenuOpen = false"
                >
                  <i class="fas fa-user mr-2"></i>Profile
                </RouterLink>
                
                <RouterLink to="/settings"
                  className="text-secondary-600 hover:text-primary-600 font-medium py-2 px-4 rounded-md hover:bg-primary-50 transition-all duration-300 text-center flex items-center justify-center"
                  @click="isMobileMenuOpen = false"
                >
                  <i class="fas fa-cog mr-2"></i>Settings
                </RouterLink>

                <button
                  @click="handleLogout"
                  className="text-red-600 hover:text-red-700 font-medium py-3 px-4 rounded-md hover:bg-red-50 transition-all duration-300 text-center flex items-center justify-center w-full"
                >
                  <i class="fas fa-sign-out-alt mr-2"></i>Sign out
                </button>
              </template>
            </div>
          </div>
        </Transition>
      </div>
    </header>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>