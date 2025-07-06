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