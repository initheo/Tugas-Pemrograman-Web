<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <div>
      <label for="name" class="form-label">Voucher Name</label>
      <input
        id="name"
        v-model="form.namaVoucher"
        type="text"
        required
        class="input-field"
      />
    </div>

    <div>
      <label for="discountRate" class="form-label">Discount Rate (%)</label>
      <input
        id="discountRate"
        v-model.number="form.diskonRate"
        type="number"
        min="0"
        max="100"
        required
        class="input-field"
      />
    </div>

    <div>
      <label for="expiryDate" class="form-label">Expiry Date</label>
      <input
        id="expiryDate"
        v-model="form.tanggalExpired"
        type="date"
        required
        class="input-field"
      />
    </div>

    <button type="submit" class="btn-primary w-full">
        Voucher
    </button>
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
      namaVoucher: '',
      diskonRate: 0,
      tanggalExpired: ''
    })

    // Watch for prop changes to populate form
    watch(() => props.voucher, (newVoucher) => {
      if (newVoucher) {
        form.value = {
          namaVoucher: newVoucher.namaVoucher || '',
          diskonRate: newVoucher.diskonRate || 0,
          tanggalExpired: newVoucher.tanggalExpired || ''
        }
      } else {
        form.value = {
          namaVoucher: '',
          diskonRate: 0,
          tanggalExpired: ''
        }
      }
    }, { immediate: true })

    const submitForm = async () => {
      try {
        if (props.mode === 'edit' && props.voucher) {
          await voucherStore.updateVoucher(props.voucher.id, form.value)
        } else {
          await voucherStore.createVoucher(form.value)
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