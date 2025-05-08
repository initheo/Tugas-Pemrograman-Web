<script setup>
import { ref } from 'vue'
import { RouterLink } from 'vue-router';
defineProps({
  msg: String,
})

const count = ref(0)
</script>

<template>
  <!-- Footer -->
    <footer className="bg-white border-t border-secondary-200">
      <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Company Info -->
          <div className="space-y-4">
            <div className="flex items-center">
              <div
                className="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white mr-3"
              >
                <i className="fas fa-tshirt"></i>
              </div>
              <span
                className="text-xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent"
              >
                LaundrEase
              </span>
            </div>
            <p className="text-secondary-600">
              Solusi laundry modern untuk kehidupan yang lebih mudah
            </p>
            <div className="flex space-x-4">
              <a
                href="#"
                className="text-secondary-400 hover:text-primary-600 transition-colors duration-300"
              >
                <i className="fab fa-facebook-f"></i>
              </a>
              <a
                href="#"
                className="text-secondary-400 hover:text-primary-600 transition-colors duration-300"
              >
                <i className="fab fa-twitter"></i>
              </a>
              <a
                href="#"
                className="text-secondary-400 hover:text-primary-600 transition-colors duration-300"
              >
                <i className="fab fa-instagram"></i>
              </a>
              <a
                href="#"
                className="text-secondary-400 hover:text-primary-600 transition-colors duration-300"
              >
                <i className="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div>
            <h3 className="text-lg font-semibold text-secondary-900 mb-4">
              Quick Links
            </h3>
            <ul className="space-y-3">
              <li>
                <RouterLink to="/about"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Tentang Kami</RouterLink>
              </li>
              <li>
                <RouterLink to="/services"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Layanan</RouterLink>
              </li>
              <li>
                <RouterLink to="/pricing"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Harga</RouterLink>
              </li>
              <li>
                <RouterLink to="/faq"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Kontak</RouterLink>
              </li>
              <li>
                <RouterLink to="/contact"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >FAQ</RouterLink>
              </li>
            </ul>
          </div>

          <!-- Services -->
          <div>
            <h3 className="text-lg font-semibold text-secondary-900 mb-4">
              Layanan
            </h3>
            <ul className="space-y-3">
              <li>
                <RouterLink
                  to="/services"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Cuci & Lipat</RouterLink>
              </li>
              <li>
                  <RouterLink
                   to="/services"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Cuci Kering</RouterLink>
              </li>
              <li> 
                <RouterLink
                   to="/services"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Setrika & Pres</RouterLink>
              </li>
              <li>
                  <RouterLink
                   to="/services"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Linen Rumah Tangga</RouterLink>
              </li>
              <li>
                  <RouterLink
                   to="/services"
                  className="text-secondary-600 hover:text-primary-600 transition-colors duration-300"
                  >Layanan Ekspres</RouterLink>
              </li>
            </ul>
          </div>

          <!-- Contact -->
          <div>
            <h3 className="text-lg font-semibold text-secondary-900 mb-4">
              Kontak
            </h3>
            <ul className="space-y-3">
              <li className="flex items-start">
                <i className="fas fa-map-marker-alt text-primary-600 mt-1 mr-3"></i>
                <span className="text-secondary-600"
                  >Jl. Raya Gresik No. 123, Gresik, Jawa Timur 61122</span
                >
              </li>
              <li className="flex items-center">
                <i className="fas fa-phone-alt text-primary-600 mr-3"></i>
                <span className="text-secondary-600">(031) 1234-5678</span>
              </li>
              <li className="flex items-center">
                <i className="fas fa-envelope text-primary-600 mr-3"></i>
                <span className="text-secondary-600">hello@laundrease.com</span>
              </li>
              <li className="flex items-center">
                <i className="fab fa-whatsapp text-primary-600 mr-3"></i>
                <span className="text-secondary-600">+62 812-3456-7890</span>
              </li>
            </ul>
          </div>
        </div>

        <div className="mt-12 pt-8 border-t border-secondary-200">
          <div className="text-center text-secondary-600">
            <p>&copy; 2024 LaundrEase. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
</template>