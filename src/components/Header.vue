<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { RouterLink, useRoute } from 'vue-router'

defineProps({
  msg: String,
})

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
          
            <RouterLink to="/"
              className="px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300"
            >Beranda</RouterLink>

            <RouterLink to="/about"
              className="px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300"
            >Tentang Kami</RouterLink>

            <RouterLink to="/services"
              className="px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300"
            >Layanan</RouterLink>

            <RouterLink to="/pricing"
              className="px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300"
            >Harga</RouterLink>

            <RouterLink to="/faq"
              className="px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300"
            >FAQ</RouterLink>


            <RouterLink to="/contact"
              className="px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300"
            >Kontak</RouterLink>

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
        <div ref="mobileMenu" id="mobile-menu" className="md:hidden hidden pb-6 animate-fade-in">
          <nav className="flex flex-col space-y-1 mt-2">

            <!-- <a
              v-for="item in navItems"
              :key="item.path"
              :href="item.path"
              :class="route.path === item.path 
                ? 'text-primary-600 font-medium py-3 px-4 rounded-md bg-primary-50 transition-all duration-300'
                : 'text-secondary-600 hover:text-primary-600 font-medium py-3 px-4 rounded-md hover:bg-primary-50 transition-all duration-300'"
            >{{ item.label }}</a> -->


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
      </div>
    </header>
</template>