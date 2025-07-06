<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <div>
      <label for="name" class="form-label">Name</label>
      <input
        id="name"
        v-model="form.nama"
        type="text"
        required
        class="input-field"
      />
    </div>

    <div>
      <label for="address" class="form-label">Address</label>
      <textarea
        id="address"
        v-model="form.alamatLengkap"
        required
        class="input-field"
      ></textarea>
    </div>

    <div>
      <label for="religion" class="form-label">Religion (Optional)</label>
      <input
        id="religion"
        v-model="form.agama"
        type="text"
        class="input-field"
      />
    </div>

    <div>
      <label for="birthDate" class="form-label">Birth Date</label>
      <input
        id="birthDate"
        v-model="form.tanggalLahir"
        type="date"
        required
        class="input-field"
      />
    </div>

    <div>
      <label for="phoneNumber" class="form-label">Phone Number</label>
      <input
        id="phoneNumber"
        v-model="form.nomorTelepon"
        type="tel"
        required
        class="input-field"
      />
    </div>

    <button type="submit" class="btn-primary w-full">
      {{ mode === 'edit' ? 'Update' : 'Add' }} Customer
    </button>
    
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
  emits: ['submit'],
  setup(props, { emit }) {
    const customerStore = useCustomerStore()
    
    const form = ref({
      nama: '',
      alamatLengkap: '',
      agama: '',
      tanggalLahir: '',
      nomorTelepon: ''
    })

    // Watch for prop changes to populate form
    watch(() => props.customer, (newCustomer) => {
      if (newCustomer) {
        form.value = {
          nama: newCustomer.nama || '',
          alamatLengkap: newCustomer.alamatLengkap || '',
          agama: newCustomer.agama || '',
          tanggalLahir: newCustomer.tanggalLahir || '',
          nomorTelepon: newCustomer.nomorTelepon || ''
        }
      } else {
        form.value = {
          nama: '',
          alamatLengkap: '',
          agama: '',
          tanggalLahir: '',
          nomorTelepon: ''
        }
      }
    }, { immediate: true })

    const submitForm = async () => {
      try {
        if (props.mode === 'edit' && props.customer) {
          await customerStore.updateCustomer(props.customer.id, form.value)
        } else {
          await customerStore.createCustomer(form.value)
        }
        emit('submit')
      } catch (error) {
        console.error('Error saving customer:', error)
        alert('Error saving customer: ' + error.message)
      }
    }

    return {
      form,
      submitForm
    }
  }
}
</script>

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
  emits: ['submit'],
  setup(props, { emit }) {
    const customerStore = useCustomerStore()
    
    const form = ref({
      nama: '',
      alamatLengkap: '',
      agama: '',
      tanggalLahir: '',
      nomorTelepon: ''
    })

    // Watch for prop changes to populate form
    watch(() => props.customer, (newCustomer) => {
      if (newCustomer) {
        form.value = {
          nama: newCustomer.nama || '',
          alamatLengkap: newCustomer.alamatLengkap || '',
          agama: newCustomer.agama || '',
          tanggalLahir: newCustomer.tanggalLahir || '',
          nomorTelepon: newCustomer.nomorTelepon || ''
        }
      } else {
        form.value = {
          nama: '',
          alamatLengkap: '',
          agama: '',
          tanggalLahir: '',
          nomorTelepon: ''
        }
      }
    }, { immediate: true })

    const submitForm = async () => {
      try {
        if (props.mode === 'edit' && props.customer) {
          await customerStore.updateCustomer(props.customer.id, form.value)
        } else {
          await customerStore.createCustomer(form.value)
        }
        emit('submit')
      } catch (error) {
        console.error('Error saving customer:', error)
        alert('Error saving customer: ' + error.message)
      }
    }

    return {
      form,
      submitForm
    }
  }
}
</script>