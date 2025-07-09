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
        <div v-if="authService.isAdmin()">
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

        <!-- Customer Info for User Role -->
        <div v-else-if="authService.isUser()">
          <label class="form-label">Customer</label>
          <div class="input-field bg-gray-100">
            <div v-if="currentCustomer && !currentCustomer._placeholder">
              <div class="font-medium">{{ currentCustomer.name }}</div>
              <div class="text-sm text-gray-600">{{ currentCustomer.email }}</div>
              <div class="text-xs text-green-600 mt-1">✓ Customer profile ready</div>
            </div>
            <div v-else-if="currentCustomer && currentCustomer._placeholder" class="text-amber-600">
              <div class="font-medium">{{ currentCustomer.name }}</div>
              <div class="text-sm text-gray-600">{{ currentCustomer.email }}</div>
              <div class="text-xs text-amber-600 mt-1">⚠ No customer profile found. Contact administrator.</div>
            </div>
            <div v-else class="text-gray-500">Loading customer data...</div>
          </div>
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
                {{ voucher.name }}{{ voucher.code ? ` (${voucher.code})` : '' }} - 
                <span v-if="voucher.discount_type === 'percentage' || !voucher.discount_type">
                  {{ voucher.discount_percentage }}% off
                </span>
                <span v-else>
                  Rp {{ Number(voucher.discount_value || voucher.discount_percentage || 0).toLocaleString() }} off
                </span>
                <span v-if="voucher.minimum_purchase && voucher.minimum_purchase > 0">
                  (Min. Rp {{ Number(voucher.minimum_purchase).toLocaleString() }})
                </span>
                <span v-if="voucher.maximum_discount && voucher.maximum_discount > 0 && (voucher.discount_type === 'percentage' || !voucher.discount_type)">
                  (Max. Rp {{ Number(voucher.maximum_discount).toLocaleString() }})
                </span>
              </option>
            </select>
            
            <!-- Debug info -->
            <div v-if="voucherStore.loading" class="text-sm text-blue-500">
              Loading vouchers...
            </div>
            <div v-else-if="voucherStore.error" class="text-sm text-red-500">
              Error loading vouchers: {{ voucherStore.error }}
            </div>
            <div v-else-if="!vouchers || vouchers.length === 0" class="text-sm text-gray-500">
              No vouchers available in database
            </div>
            <div v-else-if="availableVouchers.length === 0 && form.base_amount > 0" class="text-sm text-orange-600">
              {{ vouchers.length }} vouchers found, but none meet the minimum purchase requirement of Rp {{ form.base_amount.toLocaleString() }}
            </div>
            <div v-else-if="vouchers.length > 0" class="text-sm text-green-600">
              {{ vouchers.length }} vouchers loaded, {{ availableVouchers.length }} available for current amount
            </div>
            <div v-if="selectedVoucher" class="p-3 bg-green-50 border border-green-200 rounded-lg">
              <p class="text-sm text-green-700">
                <span class="font-medium">{{ selectedVoucher.name }}</span> applied!
                <span v-if="selectedVoucher.discount_type === 'percentage' || !selectedVoucher.discount_type">
                  {{ selectedVoucher.discount_percentage }}% discount
                  <span v-if="selectedVoucher.maximum_discount && selectedVoucher.maximum_discount > 0">
                    (max Rp {{ Number(selectedVoucher.maximum_discount).toLocaleString() }})
                  </span>
                </span>
                <span v-else>
                  Rp {{ Number(selectedVoucher.discount_value || selectedVoucher.discount_percentage).toLocaleString() }} discount
                </span>
              </p>
              <p v-if="discountAmount > 0" class="text-xs text-green-600 mt-1">
                You save: Rp {{ Number(discountAmount).toLocaleString() }}
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
import { authService } from '../services/authService'
import api from '../services/api'

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
    const currentCustomer = ref(null)

    // Computed properties
    const customers = computed(() => customerStore.customers || [])
    const branches = computed(() => branchStore.branches || [])
    const vouchers = computed(() => {
      const result = voucherStore.vouchers || []
      console.log('Computed vouchers - Raw store data:', result)
      console.log('Store state:', { 
        vouchers: voucherStore.vouchers, 
        loading: voucherStore.loading, 
        error: voucherStore.error 
      })
      return result
    })
    
    const availableVouchers = computed(() => {
      const allVouchers = vouchers.value || []
      console.log('All vouchers for filtering:', allVouchers)
      
      if (!allVouchers.length) {
        console.log('No vouchers available')
        return []
      }
      
      const filtered = allVouchers.filter(voucher => {
        console.log('Checking voucher:', voucher)
        
        // Check if voucher is active (jika field status ada)
        if (voucher.status && voucher.status !== 'active') {
          console.log('Voucher not active:', voucher.status)
          return false
        }
        
        // Check if voucher is still valid
        const today = new Date()
        const validFrom = voucher.valid_from ? new Date(voucher.valid_from) : null
        const validUntil = voucher.valid_until ? new Date(voucher.valid_until) : null
        
        if (validFrom && today < validFrom) {
          console.log('Voucher not yet valid:', validFrom)
          return false
        }
        if (validUntil && today > validUntil) {
          console.log('Voucher expired:', validUntil)
          return false
        }
        
        // Check minimum purchase requirement (jika ada)
        const baseAmount = form.value.base_amount || 0
        if (voucher.minimum_purchase && baseAmount > 0 && baseAmount < voucher.minimum_purchase) {
          console.log('Base amount too low:', baseAmount, 'required:', voucher.minimum_purchase)
          return false
        }
        
        console.log('Voucher passed all checks')
        return true
      })
      console.log('Available vouchers after filtering:', filtered)
      return filtered
    })

    // Methods
    const loadCurrentCustomer = async () => {
      if (authService.isUser()) {
        try {
          console.log('Loading current customer for user...')
          const response = await api.get('/user/profile')
          console.log('User profile response:', response.data)
          
          // Check if user has a customer profile
          if (response.data && response.data.data && response.data.data.customer) {
            currentCustomer.value = response.data.data.customer
            form.value.customer_id = response.data.data.customer.id
            console.log('Current customer loaded from profile:', currentCustomer.value)
          } else {
            // User doesn't have a customer profile yet
            console.log('User has no customer profile. Creating placeholder.')
            const userData = response.data.data.user || response.data.user || authService.getCurrentUser()
            
            if (userData) {
              // Show user data but indicate no customer profile
              currentCustomer.value = {
                id: null,
                name: userData.name,
                email: userData.email,
                _placeholder: true // Flag to indicate this is not a real customer record
              }
              form.value.customer_id = null
            }
          }
        } catch (error) {
          console.error('Error loading user profile:', error)
          alert('Error loading user profile. Please contact administrator to create your customer profile.')
        }
      }
    }

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

      console.log('Calculating total - Base amount:', baseAmount, 'Selected voucher:', selectedVoucher.value)

      if (selectedVoucher.value && baseAmount >= (selectedVoucher.value.minimum_purchase || 0)) {
        const voucher = selectedVoucher.value
        console.log('Applying voucher:', voucher)
        
        // Karena dari API hanya ada discount_percentage, anggap semua voucher adalah percentage discount
        if (voucher.discount_type === 'percentage' || !voucher.discount_type) {
          // Untuk percentage, gunakan discount_percentage
          const percentage = voucher.discount_percentage || 0
          discount = Math.floor(baseAmount * percentage / 100)
          console.log(`Percentage discount: ${percentage}% of ${baseAmount} = ${discount}`)
        } else if (voucher.discount_type === 'fixed') {
          // Untuk fixed amount, gunakan discount_value
          discount = voucher.discount_value || 0
          console.log(`Fixed discount: ${discount}`)
        }
        
        // Apply maximum discount if set
        if (voucher.maximum_discount && voucher.maximum_discount > 0) {
          const originalDiscount = discount
          discount = Math.min(discount, voucher.maximum_discount)
          if (originalDiscount !== discount) {
            console.log(`Discount capped: ${originalDiscount} -> ${discount} (max: ${voucher.maximum_discount})`)
          }
        }
        
        // Ensure discount doesn't exceed base amount
        discount = Math.min(discount, baseAmount)
      }

      discountAmount.value = discount
      const totalAmount = Math.max(0, baseAmount - discount)
      form.value.total_amount = totalAmount
      
      console.log('Final calculation:', { baseAmount, discount, totalAmount })
    }

    const validateForm = () => {
      errors.value = {}

      // For admin, customer_id is required from dropdown
      // For user, customer_id should be set automatically, but check if customer profile exists
      if (authService.isAdmin() && !form.value.customer_id) {
        errors.value.customer_id = 'Customer is required'
      } else if (authService.isUser()) {
        if (!currentCustomer.value) {
          errors.value.customer_id = 'Customer profile not loaded. Please try again.'
        } else if (currentCustomer.value._placeholder) {
          errors.value.customer_id = 'You need a customer profile to create transactions. Please contact administrator.'
        } else if (!form.value.customer_id) {
          errors.value.customer_id = 'Customer data not loaded properly. Please refresh and try again.'
        }
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

      if (!form.value.payment_method) {
        errors.value.payment_method = 'Payment method is required'
      }

      return Object.keys(errors.value).length === 0
    }

    const submitForm = () => {
      if (!validateForm()) {
        return
      }

      const transactionData = {
        ...form.value,
        voucher_id: selectedVoucherId.value ? parseInt(selectedVoucherId.value) : null,
        discount_amount: discountAmount.value
      }

      console.log('Submitting transaction data:', transactionData)
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
        console.log('Loading form data...')
        
        // Load customer data for user role
        if (authService.isUser()) {
          await loadCurrentCustomer()
        }
        
        const results = await Promise.allSettled([
          authService.isAdmin() ? customerStore.fetchCustomers() : Promise.resolve(),
          // Load branches based on user role
          authService.isUser() ? 
            // For users, load branches from user endpoint
            (async () => {
              try {
                const response = await api.get('/user/branches')
                const branchesData = response.data.data || response.data
                branchStore.branches = Array.isArray(branchesData) ? branchesData : []
                console.log('User branches loaded:', branchStore.branches.length)
              } catch (error) {
                console.error('Error loading user branches:', error)
                branchStore.branches = []
                // Fallback to admin endpoint if needed
                try {
                  await branchStore.fetchBranches()
                } catch (fallbackError) {
                  console.error('Fallback branch loading failed:', fallbackError)
                }
              }
            })() :
            branchStore.fetchBranches(),
          authService.isUser() ? 
            // For users, load vouchers from user endpoint
            (async () => {
              try {
                const response = await api.get('/user/vouchers')
                const vouchersData = response.data.data || response.data
                voucherStore.vouchers = Array.isArray(vouchersData) ? vouchersData : []
                console.log('User vouchers loaded:', voucherStore.vouchers.length)
              } catch (error) {
                console.error('Error loading user vouchers:', error)
                voucherStore.vouchers = []
              }
            })() :
            voucherStore.fetchVouchers()
        ])
        
        results.forEach((result, index) => {
          const names = ['customers', 'branches', 'vouchers']
          if (result.status === 'rejected') {
            console.error(`Failed to load ${names[index]}:`, result.reason)
          } else {
            console.log(`Successfully loaded ${names[index]}`)
          }
        })
        
        console.log('Final vouchers in store:', voucherStore.vouchers?.length || 0)
        console.log('Current customer:', currentCustomer.value)
      } catch (error) {
        console.warn('Some data failed to load:', error)
      }
    })

    // Watch for base amount changes
    watch(() => form.value.base_amount, calculateTotal)
    watch(selectedVoucher, calculateTotal)

    return {
      authService,
      form,
      selectedVoucherId,
      selectedVoucher,
      discountAmount,
      errors,
      customers,
      branches,
      vouchers,
      availableVouchers,
      currentCustomer,
      voucherStore, // Add store access for template
      loadCurrentCustomer,
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
