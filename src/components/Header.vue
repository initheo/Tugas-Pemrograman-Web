<script setup>
import { ref } from 'vue';
import { RouterLink } from 'vue-router';

defineProps({
  msg: String,
})

// Add navigation items array
const navItems = [
  { path: '/', label: 'Beranda' },
  { path: '/about', label: 'Tentang Kami' },
  { path: '/services', label: 'Layanan' },
  { path: '/pricing', label: 'Harga' },
  { path: '/faq', label: 'FAQ' },
  { path: '/contact', label: 'Kontak' }
]

const isMobileMenuOpen = ref(false);

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
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
              <div
                className="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white mr-3 transition-transform duration-300 group-hover:scale-110"
              >
                <i className="fas fa-tshirt"></i>
              </div>
              <span
                className="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent"
                >LaundrEase</span
              >
            </RouterLink>
          </div>

          <!-- Desktop Navigation -->
          <nav className="hidden md:flex space-x-1 lg:space-x-2">
            <RouterLink
              v-for="item in navItems"
              :key="item.path"
              :to="item.path"
              class="px-3 py-2 font-medium transition-all duration-300 rounded-md"
              :class="[
                $route.path === item.path
                  ? 'bg-primary-50 text-primary-600'
                  : 'text-secondary-600 hover:text-primary-600 hover:bg-primary-50'
              ]"
            >
              {{ item.label }}
            </RouterLink>
          </nav>

          <div className="hidden md:flex items-center space-x-3">
            <RouterLink to="/login"
              className="px-4 py-2 text-secondary-600 hover:text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-all duration-300"
              >Login</RouterLink>
            <RouterLink to="/register"
              className="bg-primary-600 text-white px-5 py-2 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5"
              >Sign Up</RouterLink>
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
              >
                {{ item.label }}
              </RouterLink>
            </nav>
            <div
              className="flex flex-col space-y-3 mt-4 pt-4 border-t border-secondary-100 px-4"
            >
              <RouterLink to="/login"
                className="text-secondary-600 hover:text-primary-600 font-medium py-2 px-4 rounded-md hover:bg-primary-50 transition-all duration-300 text-center"
                >Login</RouterLink>

              <RouterLink to="/register"
                className="bg-primary-600 text-white py-3 px-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 text-center"
                >Sign Up</RouterLink>
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
</style>