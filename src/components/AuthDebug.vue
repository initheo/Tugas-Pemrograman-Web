<template>
  <div v-if="showDebug" class="auth-debug">
    <div class="card mt-3" style="position: fixed; top: 10px; right: 10px; z-index: 9999; width: 300px; background: rgba(0,0,0,0.9); color: white;">
      <div class="card-header d-flex justify-content-between">
        <small>Auth Debug</small>
        <button @click="toggleDebug" class="btn btn-sm btn-outline-light">✕</button>
      </div>
      <div class="card-body">
        <div class="small">
          <p><strong>isAuthenticated:</strong> {{ authStore.isAuthenticated }}</p>
          <p><strong>Token:</strong> {{ tokenStatus }}</p>
          <p><strong>User:</strong> {{ userStatus }}</p>
          <p><strong>LocalStorage Token:</strong> {{ localToken ? 'Present' : 'Missing' }}</p>
          <p><strong>LocalStorage User:</strong> {{ localUser ? 'Present' : 'Missing' }}</p>
          <p><strong>Current Route:</strong> {{ $route.path }}</p>
        </div>
        <button @click="refreshAuth" class="btn btn-sm btn-primary">Refresh Auth</button>
        <button @click="clearAuth" class="btn btn-sm btn-danger">Clear Auth</button>
      </div>
    </div>
  </div>
  <div v-else style="position: fixed; top: 10px; right: 10px; z-index: 9999;">
    <button @click="toggleDebug" class="btn btn-sm btn-info">Debug</button>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/authStore'

export default {
  name: 'AuthDebug',
  data() {
    return {
      showDebug: false
    }
  },
  computed: {
    authStore() {
      return useAuthStore()
    },
    tokenStatus() {
      return this.authStore.token ? 'Present' : 'Missing'
    },
    userStatus() {
      return this.authStore.user ? this.authStore.user.name || this.authStore.user.email : 'Missing'
    },
    localToken() {
      return localStorage.getItem('auth_token')
    },
    localUser() {
      return localStorage.getItem('user')
    }
  },
  methods: {
    toggleDebug() {
      this.showDebug = !this.showDebug
    },
    refreshAuth() {
      this.authStore.initializeAuth()
      console.log('Auth refreshed')
    },
    clearAuth() {
      this.authStore.clearAuthData()
      console.log('Auth cleared')
    }
  }
}
</script>

<style scoped>
.auth-debug {
  font-family: monospace;
}
</style>
