<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Voucher Name</label>
      <input
        id="name"
        v-model="form.name"
        type="text"
        required
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
        placeholder="Enter voucher name"
      />
    </div>

    <div>
      <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Discount Rate (%)</label>
      <input
        id="discount_percentage"
        v-model.number="form.discount_percentage"
        type="number"
        min="0"
        max="100"
        step="0.01"
        required
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
        placeholder="Enter discount percentage"
      />
    </div>

    <div>
      <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-2">Valid From</label>
      <input
        id="valid_from"
        v-model="form.valid_from"
        type="date"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
      />
    </div>

    <div>
      <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-2">Valid Until</label>
      <input
        id="valid_until"
        v-model="form.valid_until"
        type="date"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
      />
    </div>

    <div class="flex justify-end space-x-3 pt-4">
      <button 
        type="button" 
        @click="$emit('submit')"
        class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200"
      >
        Cancel
      </button>
      <button 
        type="submit" 
        class="px-4 py-2 text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
      >
        {{ mode === 'edit' ? 'Update' : 'Create' }} Voucher
      </button>
    </div>
  </form>
</template>

<script>
import { ref, watch } from 'vue'
import { useVoucherStore } from '../stores/voucherStore'

export default {
  name: 'VoucherForm',
  props: {
    voucher: {
      type: Object,
      default: null
    },
    mode: {
      type: String,
      default: 'create'
    }
  },
  emits: ['submit'],
  setup(props, { emit }) {
    const voucherStore = useVoucherStore()
    
    const form = ref({
      name: '',
      discount_percentage: 0,
      valid_from: '',
      valid_until: ''
    })

    // Watch for prop changes to populate form
    watch(() => props.voucher, (newVoucher) => {
      if (newVoucher) {
        form.value = {
          name: newVoucher.name || '',
          discount_percentage: newVoucher.discount_percentage || 0,
          valid_from: newVoucher.valid_from || '',
          valid_until: newVoucher.valid_until || ''
        }
      } else {
        form.value = {
          name: '',
          discount_percentage: 0,
          valid_from: '',
          valid_until: ''
        }
      }
    }, { immediate: true })

    const submitForm = async () => {
      try {
        // Validate dates
        if (form.value.valid_from && form.value.valid_until) {
          if (new Date(form.value.valid_until) < new Date(form.value.valid_from)) {
            alert('Valid until date must be after valid from date')
            return
          }
        }

        if (props.mode === 'edit' && props.voucher) {
          await voucherStore.updateVoucher(props.voucher.id, form.value)
          alert('Voucher updated successfully!')
        } else {
          await voucherStore.createVoucher(form.value)
          alert('Voucher created successfully!')
        }
        emit('submit')
      } catch (error) {
        console.error('Error saving voucher:', error)
        alert('Error saving voucher: ' + error.message)
      }
    }

    return {
      form,
      submitForm
    }
  }
}
</script>