# Transaction Customer Handling

## Overview
Sistem transaksi menangani customer_id secara berbeda berdasarkan role pengguna.

## Role Admin
- **Frontend**: Wajib memilih customer dari dropdown
- **Validasi**: customer_id harus dipilih dari form
- **Backend**: Menggunakan customer_id yang dikirim dari frontend
- **Flow**: Admin → Pilih Customer → Submit → Backend terima customer_id

## Role User
- **Frontend**: Tidak ada dropdown customer, tampil info customer otomatis
- **Validasi**: Cek apakah user punya customer profile (tapi tidak validasi customer_id di form)
- **Backend**: Mengambil customer_id dari relasi user.customer
- **Flow**: User → Info Customer auto-load → Submit tanpa customer_id → Backend ambil dari user.customer

## Frontend Logic

### TransactionForm.vue
```javascript
// Admin: form.customer_id required dari dropdown
if (authStore.isAdmin && !form.value.customer_id) {
  errors.value.customer_id = 'Customer is required'
}

// User: cek customer profile ada, tapi tidak validasi form.customer_id
if (authStore.isUser) {
  if (!currentCustomer.value) {
    errors.value.customer_id = 'Customer profile not loaded'
  } else if (currentCustomer.value._placeholder) {
    errors.value.customer_id = 'You need a customer profile. Contact administrator.'
  }
}

// Submit: Hapus customer_id untuk user role
if (authStore.isUser) {
  delete transactionData.customer_id
}
```

## Backend Logic

### TransactionController.php
```php
// Validasi berbeda per role
if ($user->isAdmin()) {
    $validationRules['customer_id'] = 'required|exists:customers,id';
}

// Handle customer_id
if ($user->isUser()) {
    $customer = $user->customer;
    if (!$customer) {
        return response()->json(['message' => 'Customer profile not found'], 400);
    }
    $customerId = $customer->id;
} else {
    $customerId = $request->customer_id; // From admin form
}
```

## Database Relations
- User hasOne Customer (via customer.user_id)
- Customer belongsTo User
- Transaction belongsTo Customer
- Transaction belongsTo User (user yang buat transaksi)

## Error Handling
- Admin: Harus pilih customer, jika tidak ada → validation error
- User: Jika tidak punya customer profile → error 400 dengan pesan contact administrator
- User: Jika customer profile ada → otomatis pakai customer tersebut

## Testing
1. **Admin Login** → Buat transaksi → Harus pilih customer dari dropdown
2. **User Login** → Buat transaksi → Info customer otomatis muncul, tidak perlu pilih
3. **User tanpa customer profile** → Error message muncul
