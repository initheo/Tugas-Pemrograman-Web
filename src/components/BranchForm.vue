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