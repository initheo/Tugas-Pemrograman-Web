<template>
  <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">
          {{ mode === 'create' ? 'Add New Service' : 'Edit Service' }}
        </h2>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-gray-600"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
            Service Name
          </label>
          <input
            v-model="form.name"
            id="name"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter service name"
          />
          <span v-if="errors.name" class="text-red-500 text-sm">{{ errors.name[0] }}</span>
        </div>

        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Description
          </label>
          <textarea
            v-model="form.description"
            id="description"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter service description"
          ></textarea>
          <span v-if="errors.description" class="text-red-500 text-sm">{{ errors.description[0] }}</span>
        </div>

        <div class="mb-4">
          <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
            Price (Rp)
          </label>
          <input
            v-model="form.price"
            id="price"
            type="number"
            step="0.01"
            min="0"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter price"
          />
          <span v-if="errors.price" class="text-red-500 text-sm">{{ errors.price[0] }}</span>
        </div>

        <div class="mb-4">
          <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
            Duration
          </label>
          <input
            v-model="form.duration"
            id="duration"
            type="text"
            required
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="e.g., 30 minutes, 2 hours"
          />
          <span v-if="errors.duration" class="text-red-500 text-sm">{{ errors.duration[0] }}</span>
        </div>

        <div class="mb-4">
          <label for="service_code" class="block text-sm font-medium text-gray-700 mb-2">
            Service Code (Optional)
          </label>
          <input
            v-model="form.service_code"
            id="service_code"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter service code"
          />
          <span v-if="errors.service_code" class="text-red-500 text-sm">{{ errors.service_code[0] }}</span>
        </div>

        <div class="mb-6">
          <label class="flex items-center">
            <input
              v-model="form.is_active"
              type="checkbox"
              class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
            />
            <span class="ml-2 text-sm text-gray-700">Active Service</span>
          </label>
        </div>

        <div class="flex justify-end space-x-3">
          <button
            type="button"
            @click="$emit('close')"
            class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
          >
            <span v-if="loading">
              <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.955 8.955 0 0121 12c0 .778-.099 1.533-.284 2.262M3 12c0-.778.099-1.533.284-2.262m0 0A8.955 8.955 0 013 9.738V9.738c0-4.97 4.03-9 9-9s9 4.03 9 9v.738c0 .034-.003.068-.01.1M21 21v-5h-.582m0 0a8.955 8.955 0 01-.424 0H3.582m0 0A8.955 8.955 0 013 21v0z" />
              </svg>
              Processing...
            </span>
            <span v-else>
              {{ mode === 'create' ? 'Create Service' : 'Update Service' }}
            </span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import { useServiceStore } from '../stores/serviceStore'

const props = defineProps({
  mode: {
    type: String,
    default: 'create'
  },
  service: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'success'])

const serviceStore = useServiceStore()
const loading = ref(false)
const errors = ref({})

const form = reactive({
  name: '',
  description: '',
  price: '',
  duration: '',
  service_code: '',
  is_active: true
})

// Watch for prop changes to populate form
watch(() => props.service, (newService) => {
  if (newService && props.mode === 'edit') {
    form.name = newService.name || ''
    form.description = newService.description || ''
    form.price = newService.price || ''
    form.duration = newService.duration || ''
    form.service_code = newService.service_code || ''
    form.is_active = newService.is_active !== undefined ? newService.is_active : true
  }
}, { immediate: true })

const resetForm = () => {
  form.name = ''
  form.description = ''
  form.price = ''
  form.duration = ''
  form.service_code = ''
  form.is_active = true
  errors.value = {}
}

const handleSubmit = async () => {
  loading.value = true
  errors.value = {}

  try {
    if (props.mode === 'create') {
      await serviceStore.createService(form)
    } else {
      await serviceStore.updateService(props.service.id, form)
    }
    
    emit('success')
    resetForm()
  } catch (error) {
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors
    }
  } finally {
    loading.value = false
  }
}

// Reset form when component mounts
if (props.mode === 'create') {
  resetForm()
}
</script>

<style scoped>
/* Custom styling for the pricing toggle if needed */
.pricing-toggle {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.pricing-toggle input {
  opacity: 0;
  width: 0;
  height: 0;
}

.pricing-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 12px;
}

.pricing-slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .pricing-slider {
  background-color: #2563eb;
}

input:checked + .pricing-slider:before {
  transform: translateX(26px);
}

/* Form animations */
.form-fade-enter-active,
.form-fade-leave-active {
  transition: opacity 0.3s ease;
}

.form-fade-enter-from,
.form-fade-leave-to {
  opacity: 0;
}
</style>
