<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Transactions</h1>
      <button @click="showForm = true" class="flex items-center btn-primary">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        New Transaction
      </button>
    </div>

    <!-- Transaction list table -->
    <div class="bg-white rounded-lg shadow">
      <div class="p-6">
         <!-- Search and Items per page -->
        <div class="flex items-center justify-between mb-4">
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search transactions..."
              class="py-2 pl-10 pr-4 border rounded-lg focus:ring-2 focus:ring-primary/50"
            />
            <svg
              class="w-5 h-5 text-gray-400 absolute left-3 top-2.5"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
          </div>
          <select
            v-model="itemsPerPage"
            class="px-3 py-2 border rounded-lg"
          >
            <option :value="5">5 per page</option>
            <option :value="10">10 per page</option>
            <option :value="20">20 per page</option>
          </select>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-sm font-medium text-left text-gray-600 border-b">
                <th class="pb-4 cursor-pointer select-none">Customer</th>
                <th class="pb-4 cursor-pointer select-none">Date</th>
                <th class="pb-4 cursor-pointer select-none">Branch</th>
                <th class="pb-4 cursor-pointer select-none">Weight</th>
                <th class="pb-4 cursor-pointer select-none">Amount</th>
                <th class="pb-4 cursor-pointer select-none">Status</th>
                <th class="pb-4 cursor-pointer select-none">Payment</th>
                <th class="pb-4">Payment Link</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-if="transactionStore.loading"
                class="animate-pulse"
              >
                <td colspan="8" class="py-4 text-center">Loading...</td>
              </tr>
              <tr
                v-else-if="paginatedTransactions.length === 0"
                class="border-t"
              >
                <td colspan="8" class="py-4 text-center text-gray-500">No transactions found</td>
              </tr>
              <tr
                v-for="transaction in paginatedTransactions"
                :key="transaction.id"
                class="transition-colors border-t hover:bg-gray-50"
              >
                <td class="py-4">
                  {{ customerStore.customers.find(c => c.id === transaction.pelanggan.id)?.nama }}
                </td>
                <td>{{ new Date(transaction.tanggal).toLocaleDateString() }}</td>
                <td>
                  {{ branchStore.branches.find(b => b.id === transaction.kantor.id)?.namaCabang }}
                </td>
                <td>{{ transaction.berat }} kg</td>
                <td>Rp {{ transaction.totalNominal.toLocaleString() }}</td>
                <td>
                  <span :class="[
                    'px-2 py-1 text-xs rounded-full',
                    {
                      'bg-green-100 text-green-800': transaction.statusCucian === 'selesai',
                      'bg-yellow-100 text-yellow-800': transaction.statusCucian === 'proses',
                      'bg-gray-100 text-gray-800': transaction.statusCucian === 'pending',
                      'bg-red-100 text-red-800': transaction.statusCucian === 'expired'
                    }
                  ]">
                    {{ transaction.statusCucian }}
                  </span>
                </td>
                <td>
                  <span :class="[
                    'px-2 py-1 text-xs rounded-full',
                    {
                      'bg-green-100 text-green-800': transaction.statusPembayaran === 'berhasil',
                      'bg-yellow-100 text-yellow-800': transaction.statusPembayaran === 'pending',
                      'bg-red-100 text-red-800': transaction.statusPembayaran === 'expired'
                    }
                  ]">
                    {{ transaction.statusPembayaran }}
                  </span>
                </td>
                <td>
                  <div v-if="transaction.statusPembayaran === 'berhasil'"
                      class="inline-flex items-center justify-center w-32 px-3 py-2 text-sm font-medium text-green-700 transition-all duration-200 bg-green-100 border border-green-200 rounded-lg hover:bg-green-200">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                      <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    PAID
                  </div>
                  <a v-else-if="transaction.statusPembayaran === 'pending'"
                    :href="transaction.urlPaymentGateway"
                    target="_blank"
                    class="inline-flex items-center justify-center w-32 px-3 py-2 text-sm font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                      <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Pay Now
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-4">
          <div class="text-sm text-gray-600">
            Showing {{ ((currentPage - 1) * itemsPerPage) + 1 }} to
            {{ Math.min(currentPage * itemsPerPage, filteredTransactions.length) }} of
            {{ filteredTransactions.length }} entries
          </div>
          <div class="flex space-x-2">
            <button
              :disabled="currentPage === 1"
              @click="currentPage--"
              class="px-3 py-1 border rounded-lg disabled:opacity-50"
              :class="{ 'hover:bg-gray-100': currentPage !== 1 }"
            >
              Previous
            </button>
            <button
              :disabled="currentPage === totalPages"
              @click="currentPage++"
              class="px-3 py-1 border rounded-lg disabled:opacity-50"
              :class="{ 'hover:bg-gray-100': currentPage !== totalPages }"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Transaction Form Modal -->
    <div v-if="showForm" class="fixed inset-0 flex items-center justify-center bg-black/50">
      <div class="w-full max-w-md p-6 bg-white rounded-lg">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-semibold">New Transaction</h2>
          <button @click="showForm = false" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <label for="customer" class="form-label">Customer</label>
            <select id="customer" v-model="form.customerId" required class="input-field">
              <option value="">Select Customer</option>
              <option v-for="customer in customerStore.customers" :key="customer.id" :value="customer.id">
                {{ customer.nama }}
              </option>
            </select>
          </div>

          <div>
            <label for="branch" class="form-label">Branch</label>
            <select id="branch" v-model="form.branchId" required class="input-field">
              <option value="">Select Branch</option>
              <option v-for="branch in branchStore.branches" :key="branch.id" :value="branch.id">
                {{ branch.namaCabang }}
              </option>
            </select>
          </div>

          <div>
            <label for="weight" class="form-label">Weight (kg)</label>
            <input id="weight" v-model.number="form.weight" type="number" min="0" step="0.1" required
              class="input-field" />
          </div>

          <div>
            <label for="amount" class="form-label">Price per kg</label>
            <input id="amount" v-model.number="form.amount" type="number" readonly required class="input-field" />
          </div>

          <div>
            <label for="paymentMethod" class="form-label">Payment Method</label>
            <select id="paymentMethod" v-model="form.paymentMethod" required class="input-field">
              <option value="CASH">Cash</option>
              <option value="TRANSFER">Bank Transfer</option>
            </select>
          </div>

          <div v-if="form.paymentMethod === 'CASH'" class="space-y-4">
            <div>
              <label for="paid" class="form-label">Paid Amount</label>
              <input id="paid" v-model.number="form.paid" type="number" min="0" :max="calculateTotal" required
                class="input-field" />
            </div>
          </div>

          <div>
            <label for="voucherName" class="form-label">Voucher Code</label>
            <div class="flex gap-2">
              <input id="voucherName" v-model="form.namaVoucher" type="text" class="input-field"
                placeholder="Enter voucher name" />
              <button type="button" @click="validateVoucher" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">
                Apply
              </button>
            </div>
            <p v-if="voucherError" class="mt-1 text-sm text-red-500">
              {{ voucherError }}
            </p>
            <p v-if="selectedVoucher" class="mt-1 text-sm text-green-500">
              Voucher applied: {{ selectedVoucher.diskonRate }}% discount
            </p>
          </div>

          <div class="pt-4 border-t">
            <label for="totalAmount" class="form-label">Total Amount</label>
            <input id="totalAmount" type="number" class="input-field" :value="form.totalAmount" disabled />
          </div>

          <button type="submit" class="w-full btn-primary">
            Create Transaction
          </button>
        </form>
      </div>
    </div>
  </div>
</template>