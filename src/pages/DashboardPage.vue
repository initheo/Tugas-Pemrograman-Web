<template>
  <div class="p-6">
    <div v-if="error" class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
      {{ error }}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <div
        v-for="stat in stats"
        :key="stat.label"
        class="bg-white rounded-lg shadow p-6"
      >
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-600">{{ stat.label }}</p>
            <p class="text-2xl font-semibold mt-1">
              <span v-if="loading">Loading...</span>
              <span v-else>{{ stat.value }}</span>
            </p>
          </div>
          <div class="p-3 bg-primary/10 rounded-full">
            <svg
              class="w-6 h-6 text-primary"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                :d="stat.icon"
              />
            </svg>
          </div>
        </div>
        <p :class="[
          'text-sm mt-2',
          stat.change.startsWith('+') ? 'text-green-600' : 'text-red-600'
        ]">
          {{ stat.change }} from last week
        </p>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">The Best Customer</h2>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-left text-sm text-gray-600">
                <th class="pb-4">Customer</th>
                <th class="pb-4">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="2" class="py-4 text-center">Loading...</td>
              </tr>
              <tr v-else-if="topCustomers.length === 0">
                <td colspan="2" class="py-4 text-center text-gray-500">No data available</td>
              </tr>
              <tr
                v-else
                v-for="customer in topCustomers"
                :key="customer.name"
                class="border-t"
              >
                <td class="py-4">{{ customer.name }}</td>
                <td>Rp {{ customer.totalAmount.toLocaleString() }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow">
      <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">The Best Branch Shop</h2>
      </div>
      <div class="p-6">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-left text-sm text-gray-600">
                <th class="pb-4">Name</th>
                <th class="pb-4">Total Revenue</th>
                <th class="pb-4">Total Transaction</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="loading">
                <td colspan="3" class="py-4 text-center">Loading...</td>
              </tr>
              <tr v-else-if="topBranches.length === 0">
                <td colspan="3" class="py-4 text-center text-gray-500">No data available</td>
              </tr>
              <tr
                v-else
                v-for="branch in topBranches"
                :key="branch.name"
                class="border-t"
              >
                <td class="py-4">{{ branch.name }}</td>
                <td>Rp {{ branch.totalRevenue.toLocaleString() }}</td>
                <td>{{ branch.totalTransactions }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>