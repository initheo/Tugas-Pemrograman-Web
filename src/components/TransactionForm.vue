<template>
  <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 bg-white rounded-lg shadow-xl">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
          New Transaction
        </h2>
        <button 
          @click="$emit('close')" 
          class="text-gray-500 hover:text-gray-700 transition-colors"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Customer Selection -->
        <div>
          <label for="customer" class="form-label">Customer *</label>
          <select 
            id="customer" 
            v-model="form.customer_id" 
            required 
            class="input-field"
            :class="{ 'border-red-500': errors.customer_id }"
          >
            <option value="">Select Customer</option>
            <option 
              v-for="customer in customers" 
              :key="customer.id" 
              :value="customer.id"
            >
              {{ customer.name }} - {{ customer.email }}
            </option>
          </select>
          <p v-if="errors.customer_id" class="mt-1 text-sm text-red-500">{{ errors.customer_id }}</p>
        </div>

        <!-- Branch Selection -->
        <div>
          <label for="branch" class="form-label">Branch Store *</label>
          <select 
            id="branch" 
            v-model="form.branch_store_id" 
            required 
            class="input-field"
            :class="{ 'border-red-500': errors.branch_store_id }"
          >
            <option value="">Select Branch</option>
            <option 
              v-for="branch in branches" 
              :key="branch.id" 
              :value="branch.id"
            >
              {{ branch.name }} - {{ branch.address }}
            </option>
          </select>
          <p v-if="errors.branch_store_id" class="mt-1 text-sm text-red-500">{{ errors.branch_store_id }}</p>
        </div>

        <!-- Transaction Date -->
        <div>
          <label for="transaction_date" class="form-label">Transaction Date *</label>
          <input 
            id="transaction_date" 
            v-model="form.transaction_date" 
            type="date" 
            required 
            class="input-field"
            :class="{ 'border-red-500': errors.transaction_date }"
          />
          <p v-if="errors.transaction_date" class="mt-1 text-sm text-red-500">{{ errors.transaction_date }}</p>
        </div>

        <!-- Voucher Selection (Optional) -->
        <div>
          <label for="voucher" class="form-label">Voucher (Optional)</label>
          <div class="space-y-2">
            <select 
              id="voucher" 
              v-model="selectedVoucherId" 
              @change="applyVoucher"
              class="input-field"
            >
              <option value="">No Voucher</option>
              <option 
                v-for="voucher in availableVouchers" 
                :key="voucher.id" 
                :value="voucher.id"
              >
                {{ voucher.name }} - 
                <span v-if="voucher.discount_type === 'percentage'">
                  {{ voucher.discount_percentage || voucher.discount_value }}% off
                </span>
                <span v-else>
                  Rp {{ (voucher.discount_value || voucher.discount_percentage || 0).toLocaleString() }} off
                </span>
                <span v-if="voucher.minimum_purchase > 0">
                  (Min. Rp {{ voucher.minimum_purchase.toLocaleString() }})
                </span>
              </option>
            </select>
            <div v-if="selectedVoucher" class="p-3 bg-green-50 border border-green-200 rounded-lg">
              <p class="text-sm text-green-700">
                <span class="font-medium">{{ selectedVoucher.name }}</span> applied!
                <span v-if="selectedVoucher.discount_type === 'percentage'">
                  {{ selectedVoucher.discount_percentage || selectedVoucher.discount_value }}% discount
                </span>
                <span v-else>
                  Rp {{ (selectedVoucher.discount_value || selectedVoucher.discount_percentage || 0).toLocaleString() }} discount
                </span>
              </p>
            </div>
          </div>
        </div>

        <!-- Base Amount -->
        <div>
          <label for="base_amount" class="form-label">Base Amount *</label>
          <input 
            id="base_amount" 
            v-model.number="form.base_amount" 
            type="number" 
            min="0" 
            step="1000"
            required 
            class="input-field"
            :class="{ 'border-red-500': errors.base_amount }"
            @input="calculateTotal"
          />
          <p v-if="errors.base_amount" class="mt-1 text-sm text-red-500">{{ errors.base_amount }}</p>
        </div>

        <!-- Discount Amount (Calculated) -->
        <div v-if="discountAmount > 0">
          <label class="form-label">Discount Amount</label>
          <input 
            type="text" 
            :value="'- Rp ' + discountAmount.toLocaleString()" 
            class="input-field bg-gray-100" 
            disabled 
          />
        </div>

        <!-- Total Amount (Calculated) -->
        <div>
          <label for="total_amount" class="form-label">Total Amount *</label>
          <input 
            id="total_amount" 
            v-model.number="form.total_amount" 
            type="number" 
            required 
            class="input-field bg-gray-100 font-semibold" 
            disabled 
          />
        </div>

        <!-- Payment Method -->
        <div>
          <label for="payment_method" class="form-label">Payment Method *</label>
          <select 
            id="payment_method" 
            v-model="form.payment_method" 
            required 
            class="input-field"
            :class="{ 'border-red-500': errors.payment_method }"
          >
            <option value="">Select Payment Method</option>
            <option value="CASH">Cash</option>
            <option value="TRANSFER">Bank Transfer (Online Payment)</option>
          </select>
          <p v-if="errors.payment_method" class="mt-1 text-sm text-red-500">{{ errors.payment_method }}</p>
          <p v-if="form.payment_method === 'TRANSFER'" class="mt-1 text-sm text-blue-600">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            A payment link will be generated for online payment
          </p>
        </div>

        <!-- Notes -->
        <div>
          <label for="notes" class="form-label">Notes</label>
          <textarea 
            id="notes" 
            v-model="form.notes" 
            rows="3" 
            class="input-field"
            placeholder="Additional notes (optional)"
          ></textarea>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-3 pt-6 border-t">
          <button 
            type="button" 
            @click="$emit('close')" 
            class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
          >
            Cancel
          </button>
          <button 
            type="submit" 
            :disabled="loading"
            class="btn-primary flex items-center space-x-2"
          >
            <svg 
              v-if="loading" 
              class="w-4 h-4 animate-spin" 
              fill="none" 
              viewBox="0 0 24 24"
            >
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ loading ? 'Saving...' : 'Create Transaction' }}</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, computed, watch, onMounted } from 'vue'
import { useCustomerStore } from '../stores/customerStore'
import { useBranchStore } from '../stores/branchStore'
import { useVoucherStore } from '../stores/voucherStore'

export default {
  name: 'TransactionForm',
  props: {
    loading: {
      type: Boolean,
      default: false
    }
  },
  emits: ['close', 'submit'],
  setup(props, { emit }) {
    const customerStore = useCustomerStore()
    const branchStore = useBranchStore()
    const voucherStore = useVoucherStore()

    // Form state
    const form = ref({
      customer_id: '',
      branch_store_id: '',
      transaction_date: new Date().toISOString().split('T')[0],
      base_amount: 0,
      total_amount: 0,
      payment_method: '',
      notes: ''
    })

    const selectedVoucherId = ref('')
    const selectedVoucher = ref(null)
    const discountAmount = ref(0)
    const errors = ref({})

    // Computed properties
    const customers = computed(() => customerStore.customers || [])
    const branches = computed(() => branchStore.branches || [])
    const vouchers = computed(() => voucherStore.vouchers || [])
    
    const availableVouchers = computed(() => {
      return vouchers.value.filter(voucher => 
        voucher.status === 'active' && 
        new Date(voucher.valid_until) >= new Date() &&
        (voucher.minimum_purchase === 0 || form.value.base_amount >= voucher.minimum_purchase)
      )
    })

    // Methods
    const applyVoucher = () => {
      if (selectedVoucherId.value) {
        selectedVoucher.value = availableVouchers.value.find(v => v.id === parseInt(selectedVoucherId.value))
      } else {
        selectedVoucher.value = null
      }
      calculateTotal()
    }

    const calculateTotal = () => {
      const baseAmount = form.value.base_amount || 0
      let discount = 0

      if (selectedVoucher.value && baseAmount >= (selectedVoucher.value.minimum_purchase || 0)) {
        if (selectedVoucher.value.discount_type === 'percentage') {
          discount = Math.floor(baseAmount * (selectedVoucher.value.discount_percentage || selectedVoucher.value.discount_value || 0) / 100)
        } else {
          discount = selectedVoucher.value.discount_value || selectedVoucher.value.discount_percentage || 0
        }
        
        // Apply maximum discount if set
        if (selectedVoucher.value.maximum_discount && selectedVoucher.value.maximum_discount > 0) {
          discount = Math.min(discount, selectedVoucher.value.maximum_discount)
        }
        
        // Ensure discount doesn't exceed base amount
        discount = Math.min(discount, baseAmount)
      }

      discountAmount.value = discount
      form.value.total_amount = baseAmount - discount
    }

    const validateForm = () => {
      errors.value = {}

      if (!form.value.customer_id) {
        errors.value.customer_id = 'Customer is required'
      }
      if (!form.value.branch_store_id) {
        errors.value.branch_store_id = 'Branch store is required'
      }
      if (!form.value.transaction_date) {
        errors.value.transaction_date = 'Transaction date is required'
      }
      if (!form.value.base_amount || form.value.base_amount <= 0) {
        errors.value.base_amount = 'Base amount must be greater than 0'
      }

      return Object.keys(errors.value).length === 0
    }

    const submitForm = () => {
      if (!validateForm()) {
        return
      }

      const transactionData = {
        ...form.value,
        voucher_id: selectedVoucherId.value || null,
        discount_amount: discountAmount.value
      }

      emit('submit', transactionData)
    }

    const resetForm = () => {
      form.value = {
        customer_id: '',
        branch_store_id: '',
        transaction_date: new Date().toISOString().split('T')[0],
        base_amount: 0,
        total_amount: 0,
        notes: ''
      }
      selectedVoucherId.value = ''
      selectedVoucher.value = null
      discountAmount.value = 0
      errors.value = {}
    }

    // Load data and initialize form
    onMounted(async () => {
      try {
        await Promise.allSettled([
          customerStore.fetchCustomers(),
          branchStore.fetchBranches(),
          voucherStore.fetchVouchers()
        ])
      } catch (error) {
        console.warn('Some data failed to load:', error)
      }
    })

    // Watch for base amount changes
    watch(() => form.value.base_amount, calculateTotal)
    watch(selectedVoucher, calculateTotal)

    return {
      form,
      selectedVoucherId,
      selectedVoucher,
      discountAmount,
      errors,
      customers,
      branches,
      availableVouchers,
      applyVoucher,
      calculateTotal,
      submitForm,
      resetForm
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

.input-field:disabled {
  background-color: #f9fafb;
  color: #6b7280;
}
</style>
