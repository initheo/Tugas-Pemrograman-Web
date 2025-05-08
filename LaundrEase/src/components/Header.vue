<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'

defineProps({
  msg: String,
})

const route = useRoute()
const count = ref(0)
const mobileMenu = ref(null)
const header = ref(null)

// Navigation items
const navItems = [
  { path: '/', label: 'Beranda' },
  { path: '/about', label: 'Tentang Kami' },
  { path: '/services', label: 'Layanan' },
  { path: '/pricing', label: 'Harga' },
  { path: '/faq', label: 'FAQ' },
  { path: '/contact', label: 'Kontak' }
]

// Get nav link classes based on current route
const getNavLinkClasses = (path) => {
  const isActive = route.path === path
  return isActive
    ? 'px-3 py-2 text-primary-600 font-medium rounded-md bg-primary-50 transition-all duration-300'
    : 'px-3 py-2 text-secondary-600 hover:text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-all duration-300'
}

// Mobile menu toggle
const toggleMobileMenu = () => {
  mobileMenu.value?.classList.toggle('hidden')
}

// Smooth scrolling for anchor links
const setupSmoothScroll = () => {
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault()

      const targetId = this.getAttribute('href')
      if (targetId === '#') return

      const targetElement = document.querySelector(targetId)
      if (targetElement) {
        targetElement.scrollIntoView({
          behavior: 'smooth'
        })

        // Close mobile menu if open
        if (mobileMenu.value && !mobileMenu.value.classList.contains('hidden')) {
          mobileMenu.value.classList.add('hidden')
        }
      }
    })
  })
}

// Reveal animations
const reveal = () => {
  const reveals = document.querySelectorAll('.reveal')
  
  reveals.forEach(element => {
    const windowHeight = window.innerHeight
    const elementTop = element.getBoundingClientRect().top
    const elementVisible = 150

    if (elementTop < windowHeight - elementVisible) {
      element.classList.add('active')
    }
  })
}

// Sticky header effect
const handleScroll = () => {
  if (header.value) {
    if (window.scrollY > 50) {
      header.value.classList.add('shadow-md')
      header.value.classList.remove('shadow-sm')
    } else {
      header.value.classList.remove('shadow-md')
      header.value.classList.add('shadow-sm')
    }
  }
  reveal()
}

// Lifecycle hooks
onMounted(() => {
  setupSmoothScroll()
  window.addEventListener('scroll', handleScroll)
  reveal() // Initial reveal check
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
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
            <a href="/" className="flex items-center group">
              <div
                className="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white mr-3 transition-transform duration-300 group-hover:scale-110"
              >
                <i className="fas fa-tshirt"></i>
              </div>
              <span
                className="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent"
                >LaundrEase</span
              >
            </a>
          </div>

          <!-- Desktop Navigation -->
          <nav className="hidden md:flex space-x-1 lg:space-x-2">
            <a
              v-for="item in navItems"
              :key="item.path"
              :href="item.path"
              :class="getNavLinkClasses(item.path)"
            >{{ item.label }}</a>
          </nav>

          <div className="hidden md:flex items-center space-x-3">
            <a
              href="/login"
              className="px-4 py-2 text-secondary-600 hover:text-primary-600 font-medium rounded-md hover:bg-primary-50 transition-all duration-300"
              >Login</a
            >
            <a
              href="/register"
              className="bg-primary-600 text-white px-5 py-2 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5"
              >Sign Up</a
            >
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
            <a
              v-for="item in navItems"
              :key="item.path"
              :href="item.path"
              :class="route.path === item.path 
                ? 'text-primary-600 font-medium py-3 px-4 rounded-md bg-primary-50 transition-all duration-300'
                : 'text-secondary-600 hover:text-primary-600 font-medium py-3 px-4 rounded-md hover:bg-primary-50 transition-all duration-300'"
            >{{ item.label }}</a>
          </nav>
          <div
            className="flex flex-col space-y-3 mt-4 pt-4 border-t border-secondary-100 px-4"
          >
            <a
              href="/login"
              className="text-secondary-600 hover:text-primary-600 font-medium py-2 px-4 rounded-md hover:bg-primary-50 transition-all duration-300 text-center"
              >Login</a
            >
            <a
              href="/register"
              className="bg-primary-600 text-white py-3 px-4 rounded-md font-medium hover:bg-primary-700 shadow-md hover:shadow-lg transition-all duration-300 text-center"
              >Sign Up</a
            >
          </div>
        </div>
      </div>
    </header>
</template>