<template>
  <div>
    
    
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
          <!-- Error message -->
          <div v-if="error" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
            <p class="text-red-600 text-sm">{{ error }}</p>
          </div>

          <!-- Success message -->
          <div v-if="success" class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
            <p class="text-green-600 text-sm">{{ success }}</p>
          </div>

          <form @submit.prevent="handleSubmit" className="space-y-6">
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
                  v-model="form.name"
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
                  v-model="form.email"
                  name="email"
                  type="email"
                  autocomplete="email"
                  required
                  className="appearance-none block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="nama@email.com"
                />
              </div>
            </div>

            <!-- Phone Input -->
            <div>
              <label for="phone" className="block text-sm font-medium text-secondary-700 mb-1">
                Nomor Telepon (Opsional)
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i className="fas fa-phone text-secondary-400"></i>
                </div>
                <input
                  id="phone"
                  v-model="form.phone"
                  name="phone"
                  type="tel"
                  className="appearance-none block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="08123456789"
                />
              </div>
            </div>

            <!-- Address Input -->
            <div>
              <label for="address" className="block text-sm font-medium text-secondary-700 mb-1">
                Alamat (Opsional)
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 pt-3 flex items-start pointer-events-none">
                  <i className="fas fa-map-marker-alt text-secondary-400"></i>
                </div>
                <textarea
                  id="address"
                  v-model="form.address"
                  name="address"
                  rows="3"
                  className="appearance-none block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300 resize-none"
                  placeholder="Alamat lengkap Anda"
                ></textarea>
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
                  v-model="form.password"
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

            <!-- Confirm Password Input -->
            <div>
              <label for="password_confirmation" className="block text-sm font-medium text-secondary-700 mb-1">
                Konfirmasi Kata Sandi
              </label>
              <div className="relative">
                <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i className="fas fa-lock text-secondary-400"></i>
                </div>
                <input
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  name="password_confirmation"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  required
                  className="appearance-none block w-full pl-10 pr-10 py-3 border border-secondary-300 rounded-md shadow-sm placeholder-secondary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                  placeholder="••••••••"
                />
                <div className="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <button
                    type="button"
                    @click="toggleConfirmPassword"
                    className="text-secondary-400 hover:text-secondary-600 focus:outline-none"
                  >
                    <i :className="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                  </button>
                </div>
              </div>
            </div>

            <!-- Terms Checkbox -->
            <div className="flex items-center">
              <input
                id="terms"
                v-model="form.terms"
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
                :disabled="loading"
                className="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
              >
                <i v-if="loading" className="fas fa-spinner fa-spin mr-2"></i>
                {{ loading ? 'Mendaftar...' : 'Daftar' }}
              </button>
            </div>
          </form>

        

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
import { ref, reactive } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/authStore'
import Footer from '../components/Footer.vue'
import Header from '../components/Header.vue'

const router = useRouter()
const authStore = useAuthStore()

const showPassword = ref(false)
const showConfirmPassword = ref(false)
const loading = ref(false)
const error = ref('')
const success = ref('')

const form = reactive({
  name: '',
  email: '',
  phone: '',
  address: '',
  password: '',
  password_confirmation: '',
  terms: false
})

const togglePassword = () => {
  showPassword.value = !showPassword.value
}

const toggleConfirmPassword = () => {
  showConfirmPassword.value = !showConfirmPassword.value
}

const handleSubmit = async () => {
  error.value = ''
  success.value = ''

  // Validate password confirmation
  if (form.password !== form.password_confirmation) {
    error.value = 'Konfirmasi kata sandi tidak cocok'
    return
  }

  // Validate terms
  if (!form.terms) {
    error.value = 'Anda harus menyetujui syarat dan ketentuan'
    return
  }

  loading.value = true

  try {
    const registrationData = {
      name: form.name,
      email: form.email,
      phone: form.phone || null,
      address: form.address || null,
      password: form.password,
      password_confirmation: form.password_confirmation
    }

    const result = await authStore.register(registrationData)

    if (result.success) {
      success.value = 'Pendaftaran berhasil! Mengalihkan ke dashboard...'
      
      // Redirect langsung ke dashboard
      await router.push('/dashboard')
    } else {
      error.value = result.error || 'Pendaftaran gagal'
    }
  } catch (err) {
    error.value = err.message || 'Terjadi kesalahan saat pendaftaran'
  } finally {
    loading.value = false
  }
}
</script>