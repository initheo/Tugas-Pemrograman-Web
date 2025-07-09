<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <!-- Name field -->
    <div>
      <label for="name" class="form-label">Name *</label>
      <input
        id="name"
        v-model="form.name"
        type="text"
        required
        class="input-field"
        :class="{ 'border-red-500': errors.name }"
      />
      <p v-if="errors.name" class="mt-1 text-sm text-red-500">{{ errors.name[0] }}</p>
    </div>

    <!-- Email field -->
    <div>
      <label for="email" class="form-label">Email *</label>
      <input
        id="email"
        v-model="form.email"
        type="email"
        required
        class="input-field"
        :class="{ 'border-red-500': errors.email }"
      />
      <p v-if="errors.email" class="mt-1 text-sm text-red-500">{{ errors.email[0] }}</p>
    </div>

    <!-- Password field (only for new customers) -->
    <div v-if="mode === 'create'">
      <label for="password" class="form-label">Password *</label>
      <input
        id="password"
        v-model="form.password"
        type="password"
        required
        class="input-field"
        :class="{ 'border-red-500': errors.password }"
      />
      <p v-if="errors.password" class="mt-1 text-sm text-red-500">{{ errors.password[0] }}</p>
    </div>

    <!-- Password field (optional for edit) -->
    <div v-else>
      <label for="password" class="form-label">New Password (Optional)</label>
      <input
        id="password"
        v-model="form.password"
        type="password"
        class="input-field"
        :class="{ 'border-red-500': errors.password }"
        placeholder="Leave blank to keep current password"
      />
      <p v-if="errors.password" class="mt-1 text-sm text-red-500">{{ errors.password[0] }}</p>
    </div>

    <!-- Role field -->
    <div>
      <label for="role" class="form-label">Role</label>
      <select
        id="role"
        v-model="form.role"
        class="input-field"
        :class="{ 'border-red-500': errors.role }"
      >
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <p v-if="errors.role" class="mt-1 text-sm text-red-500">{{ errors.role[0] }}</p>
    </div>

    <!-- Phone Number field -->
    <div>
      <label for="phone_number" class="form-label">Phone Number</label>
      <input
        id="phone_number"
        v-model="form.phone_number"
        type="tel"
        class="input-field"
        :class="{ 'border-red-500': errors.phone_number }"
      />
      <p v-if="errors.phone_number" class="mt-1 text-sm text-red-500">{{ errors.phone_number[0] }}</p>
    </div>

    <!-- Address field -->
    <div>
      <label for="address" class="form-label">Address</label>
      <textarea
        id="address"
        v-model="form.address"
        class="input-field"
        :class="{ 'border-red-500': errors.address }"
        rows="3"
      ></textarea>
      <p v-if="errors.address" class="mt-1 text-sm text-red-500">{{ errors.address[0] }}</p>
    </div>

    <!-- City field -->
    <div>
      <label for="city" class="form-label">City</label>
      <input
        id="city"
        v-model="form.city"
        type="text"
        class="input-field"
        :class="{ 'border-red-500': errors.city }"
      />
      <p v-if="errors.city" class="mt-1 text-sm text-red-500">{{ errors.city[0] }}</p>
    </div>

    <!-- Postal Code field -->
    <div>
      <label for="postal_code" class="form-label">Postal Code</label>
      <input
        id="postal_code"
        v-model="form.postal_code"
        type="text"
        class="input-field"
        :class="{ 'border-red-500': errors.postal_code }"
      />
      <p v-if="errors.postal_code" class="mt-1 text-sm text-red-500">{{ errors.postal_code[0] }}</p>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end space-x-2 pt-4">
      <button 
        type="button" 
        @click="$emit('close')"
        class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50"
      >
        Cancel
      </button>
      <button 
        type="submit" 
        class="btn-primary"
        :disabled="loading"
      >
        <span v-if="loading" class="animate-spin mr-2">⏳</span>
        {{ mode === 'edit' ? 'Update' : 'Create' }} Customer
      </button>
    </div>
  </form>
</template>

<script>
import { ref, watch } from 'vue'
import { useCustomerStore } from '../stores/customerStore'

export default {
  name: 'CustomerForm',
  props: {
    customer: {
      type: Object,
      default: null
    },
    mode: {
      type: String,
      default: 'create'
    }
  },
  emits: ['submit', 'close'],
  setup(props, { emit }) {
    const customerStore = useCustomerStore()
    
    const form = ref({
      name: '',
      email: '',
      password: '',
      role: 'user',
      phone_number: '',
      address: '',
      city: '',
      postal_code: ''
    })

    const errors = ref({})
    const loading = ref(false)

    // Watch for prop changes to populate form
    watch(() => props.customer, (newCustomer) => {
      if (newCustomer) {
        form.value = {
          name: newCustomer.name || '',
          email: newCustomer.email || '',
          password: '', // Never pre-fill password
          role: newCustomer.user?.role || 'user',
          phone_number: newCustomer.phone_number || '',
          address: newCustomer.address || '',
          city: newCustomer.city || '',
          postal_code: newCustomer.postal_code || ''
        }
      } else {
        // Reset form for create mode
        form.value = {
          name: '',
          email: '',
          password: '',
          role: 'user',
          phone_number: '',
          address: '',
          city: '',
          postal_code: ''
        }
      }
      errors.value = {} // Clear errors when customer changes
    }, { immediate: true })

    const submitForm = async () => {
      try {
        loading.value = true
        errors.value = {}

        if (props.mode === 'edit' && props.customer) {
          await customerStore.updateCustomer(props.customer.id, form.value)
          alert('Customer updated successfully!')
        } else {
          await customerStore.createCustomer(form.value)
          alert('Customer created successfully!')
        }
        emit('submit')
      } catch (error) {
        console.error('Error saving customer:', error)
        
        // Handle validation errors
        if (error.response?.status === 422 && error.response?.data?.errors) {
          errors.value = error.response.data.errors
        } else {
          alert('Error saving customer: ' + (error.response?.data?.message || error.message))
        }
      } finally {
        loading.value = false
      }
    }

    return {
      form,
      errors,
      loading,
      submitForm
    }
  }
}
</script>

<style scoped>
.btn-primary {
  padding: 0.5rem 1rem;
  background-color: #2563eb;
  color: white;
  border-radius: 0.5rem;
  transition: all 0.2s;
  border: none;
  cursor: pointer;
}

.btn-primary:hover:not(:disabled) {
  background-color: #1d4ed8;
}

.btn-primary:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.25rem;
}

.input-field {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}

.input-field:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.border-red-500 {
  border-color: #ef4444;
}
</style>