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
       Customer
    </button>
    
  </form>
</template>