<template>
  <div>
    <Header />
    
    <!-- Register Section -->
    <main className="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div className="max-w-md w-full space-y-8 reveal">
        <div className="text-center">
          <div className="w-16 h-16 bg-primary-600 rounded-full flex items-center justify-center text-white mx-auto mb-6">
            <i className="fas fa-user-plus text-2xl"></i>
          </div>
          <h2 className="text-3xl font-bold text-secondary-900 mb-2">
            Buat Akun Baru
          </h2>
          <p className="text-secondary-600">
            Daftar untuk menggunakan layanan LaundrEase
          </p>
        </div>

        <div className="bg-white p-8 rounded-xl shadow-md">
          <form className="space-y-6" action="#" method="POST">
            <!-- Full Name Input -->
            <div>
              <label for="name" className="block text-sm font-medium text-secondary-700 mb-1">
                Nama Lengkap
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i className="fas fa-user text-secondary-400"></i>
                </div>
                <input
                  id="name"
                  name="name"
                  type="text"
                  required
                  className="appearance-none block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="John Doe"
                />
              </div>
            </div>

            <!-- Email Input -->
            <div>
              <label for="email" className="block text-sm font-medium text-secondary-700 mb-1">
                Alamat Email
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i className="fas fa-envelope text-secondary-400"></i>
                </div>
                <input
                  id="email"
                  name="email"
                  type="email"
                  autocomplete="email"
                  required
                  className="appearance-none block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="nama@email.com"
                />
              </div>
            </div>

            <!-- Password Input -->
            <div>
              <label for="password" className="block text-sm font-medium text-secondary-700 mb-1">
                Kata Sandi
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i className="fas fa-lock text-secondary-400"></i>
                </div>
                <input
                  id="password"
                  name="password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  className="appearance-none block w-full pl-10 pr-10 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="••••••••"
                />
                <div className="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <button
                    type="button"
                    @click="togglePassword"
                    className="text-secondary-400 hover:text-secondary-600 focus:outline-none"
                  >
                    <i :className="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Terms Checkbox -->
            <div className="flex items-center">
              <input
                id="terms"
                name="terms"
                type="checkbox"
                required
                className="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded transition-all duration-300"
              />
              <label for="terms" className="ml-2 block text-sm text-secondary-700">
                Saya menyetujui
                <a href="#" className="text-primary-600 hover:text-primary-700">
                  Syarat dan Ketentuan
                </a>
                serta
                <a href="#" className="text-primary-600 hover:text-primary-700">
                  Kebijakan Privasi
                </a>
              </label>
            </div>

            <!-- Submit Button -->
            <div>
              <button
                type="submit"
                className="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5"
              >
                Daftar
              </button>
            </div>
          </form>

          <!-- Social Login -->
          <div className="mt-6">
            <div className="relative">
              <div className="absolute inset-0 flex items-center">
                <div className="w-full border-t border-secondary-200"></div>
              </div>
              <div className="relative flex justify-center text-sm">
                <span className="px-2 bg-white text-secondary-500">
                  Atau daftar dengan
                </span>
              </div>
            </div>

            <div className="mt-6 grid grid-cols-2 gap-3">
              <a
                href="#"
                className="w-full flex items-center justify-center px-4 py-2 border border-secondary-300 rounded-md shadow-sm text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 transition-all duration-300"
              >
                <i className="fab fa-google text-red-500 mr-2"></i>
                Google
              </a>
              <a
                href="#"
                className="w-full flex items-center justify-center px-4 py-2 border border-secondary-300 rounded-md shadow-sm text-sm font-medium text-secondary-700 bg-white hover:bg-secondary-50 transition-all duration-300"
              >
                <i className="fab fa-facebook text-blue-600 mr-2"></i>
                Facebook
              </a>
            </div>
          </div>

          <!-- Login Link -->
          <div className="text-center mt-6">
            <p className="text-sm text-secondary-600">
              Sudah memiliki akun?
              <RouterLink
                to="/login"
                className="font-medium text-primary-600 hover:text-primary-700 transition-all duration-300"
              >
                Masuk sekarang
              </RouterLink>
            </p>
          </div>
        </div>
      </div>
    </main>

    <Footer />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { RouterLink } from 'vue-router';
import Footer from '../components/Footer.vue';
import Header from '../components/Header.vue';

const showPassword = ref(false);

const togglePassword = () => {
  showPassword.value = !showPassword.value;
};
</script>

