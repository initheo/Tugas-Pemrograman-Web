<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Vouchers</h1>
      <button
        @click="openCreateForm"
        class="flex items-center btn-primary"
      >
        <svg
          class="w-5 h-5 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
          />
        </svg>
        Add Voucher
      </button>
    </div>

    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-sm text-left text-gray-600">
                <th class="pb-4">Name</th>
                <th class="pb-4">Discount Rate</th>
                <th class="pb-4">Expiry Date</th>
                <th class="pb-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="voucher in voucherStore.vouchers"
                :key="voucher.id"
                class="border-t"
              >
                <td class="py-4">{{ voucher.namaVoucher }}</td>
                <td>{{ voucher.diskonRate }}%</td>
                <td>{{ voucher.tanggalExpired }}</td>
                <td>
                  <button
                    @click="openEditForm(voucher)"
                    class="text-primary hover:text-primary/80"
                  >
                    Edit
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Voucher Form Modal -->
    <div
      v-if="showForm"
      class="fixed inset-0 flex items-center justify-center bg-black/50"
    >
      <div class="w-full max-w-md p-6 bg-white rounded-lg">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-semibold">
            {{ formMode === 'edit' ? 'Edit' : 'Add New' }} Voucher
          </h2>
          <button @click="closeForm" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <VoucherForm
          :voucher="selectedVoucher"
          :mode="formMode"
          @submit="closeForm"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useVoucherStore } from '../stores/voucherStore'
import VoucherForm from '../components/VoucherForm.vue'

export default {
  name: 'VouchersPage',
  components: {
    VoucherForm
  },
  setup() {
    const voucherStore = useVoucherStore()
    
    // Reactive data
    const showForm = ref(false)
    const selectedVoucher = ref(null)
    const formMode = ref('create')

    // Methods
    const openCreateForm = () => {
      selectedVoucher.value = null
      formMode.value = 'create'
      showForm.value = true
    }

    const openEditForm = (voucher) => {
      selectedVoucher.value = voucher
      formMode.value = 'edit'
      showForm.value = true
    }

    const closeForm = () => {
      showForm.value = false
      selectedVoucher.value = null
      formMode.value = 'create'
    }

    const loadVouchers = async () => {
      try {
        await voucherStore.fetchVouchers()
      } catch (error) {
        console.error('Error loading vouchers:', error)
      }
    }

    // Load vouchers on component mount
    onMounted(() => {
      loadVouchers()
    })

    return {
      voucherStore,
      showForm,
      selectedVoucher,
      formMode,
      openCreateForm,
      openEditForm,
      closeForm,
      loadVouchers
    }
  }
}
</script>