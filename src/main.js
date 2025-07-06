import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import './assets/main.css'
import router from './router'
import { useAuthStore } from './stores/authStore'
import './utils/authDebug.js' // Import debug utilities

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

// Initialize auth store after pinia is available
const authStore = useAuthStore()
authStore.initializeAuth()

app.mount('#app')

console.log('App initialized. Use debugAuth() in console to check auth state.')
