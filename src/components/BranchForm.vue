<template>
  <form @submit.prevent="submitForm" class="space-y-4">
    <div>
      <label for="name" class="form-label">Branch Name</label>
      <input
        id="name"
        v-model="form.namaCabang"
        type="text"
        required
        class="input-field"
      />
    </div>

    <div>
      <label for="city" class="form-label">City</label>
      <input
        id="city"
        v-model="form.kota"
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

    <button type="submit" class="btn-primary w-full">
        Branch
    </button>
  </form>
</template>

<script>
import { ref, watch } from 'vue'
import { useBranchStore } from '../stores/branchStore'

export default {
  name: 'BranchForm',
  props: {
    branch: {
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
    const branchStore = useBranchStore()
    
    const form = ref({
      namaCabang: '',
      kota: '',
      alamatLengkap: ''
    })

    // Watch for prop changes to populate form
    watch(() => props.branch, (newBranch) => {
      if (newBranch) {
        form.value = {
          namaCabang: newBranch.namaCabang || newBranch.nama || '',
          kota: newBranch.kota || '',
          alamatLengkap: newBranch.alamatLengkap || newBranch.alamat || ''
        }
      } else {
        form.value = {
          namaCabang: '',
          kota: '',
          alamatLengkap: ''
        }
      }
    }, { immediate: true })

    const submitForm = async () => {
      try {
        if (props.mode === 'edit' && props.branch) {
          await branchStore.updateBranch(props.branch.id, form.value)
        } else {
          await branchStore.createBranch(form.value)
        }
        emit('submit')
      } catch (error) {
        console.error('Error saving branch:', error)
        alert('Error saving branch: ' + error.message)
      }
    }

    return {
      form,
      submitForm
    }
  }
}
</script>