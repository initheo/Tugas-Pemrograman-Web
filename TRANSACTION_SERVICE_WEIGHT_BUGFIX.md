# Transaction with Service & Weight - Bug Fix

## Masalah yang Diperbaiki

**Error:** "The given data was invalid" saat user dengan role 'user' mencoba membuat transaksi baru.

**Penyebab:** 
- Backend memvalidasi `customer_id` sebagai required field, tetapi untuk user role, customer_id seharusnya diambil otomatis dari relasi user->customer
- Frontend mengirim `customer_id: null` untuk user yang belum punya customer profile

## Solusi yang Diterapkan

### 1. Backend (TransactionController.php)

**Perubahan Validasi:**
- Admin: `customer_id` required dari request
- User: `customer_id` tidak divalidasi dari request, akan diambil dari `$user->customer`

**Logika Baru:**
```php
// Different validation rules based on user role
if ($user->isAdmin()) {
    $validationRules['customer_id'] = 'required|exists:customers,id';
}

// Handle customer_id based on user role
if ($user->isUser()) {
    $customer = $user->customer; // Get from relationship
    if (!$customer) {
        return response()->json([
            'message' => 'Customer profile not found. Please contact administrator...'
        ], 400);
    }
    $customerId = $customer->id;
} else {
    $customerId = $request->customer_id; // From admin request
}
```

### 2. Frontend (TransactionForm.vue)

**Perubahan Submit:**
```javascript
// For user role, don't send customer_id (backend will get it from user's customer relationship)
if (authStore.isUser) {
    delete transactionData.customer_id
}
```

**Perubahan Validasi:**
- User: Hanya cek apakah customer profile loaded (informational)
- Admin: Tetap validasi customer_id required

**Perubahan loadCurrentCustomer:**
- Tidak lagi set `form.value.customer_id` untuk user role
- Backend akan mengambil customer_id otomatis dari relasi

## Model Relationships

**User Model:**
```php
public function customer()
{
    return $this->hasOne(Customer::class);
}
```

**Customer Model:**
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

## Fitur Service & Weight

**Database Fields (transactions table):**
- `service_id` (foreign key ke services table)
- `weight` (decimal untuk berat/quantity)

**Perhitungan:**
- `base_amount = weight × service.price`
- `total_amount = base_amount - discount_amount`

**Frontend:**
- Dropdown service selection
- Input weight/quantity
- Auto-calculation base amount
- Display calculation: "2.5 × Rp 15,000 = Rp 37,500"

## Testing Checklist

- [x] Admin dapat memilih customer dan membuat transaksi
- [x] User dengan customer profile dapat membuat transaksi
- [x] User tanpa customer profile mendapat error message yang jelas
- [x] Service selection dan weight calculation berfungsi
- [x] Validasi field service_id dan weight
- [x] Display service info di transaction list

## Notes

- User harus memiliki customer profile (dibuat oleh admin) untuk bisa membuat transaksi
- Backend otomatis mengambil customer_id dari user->customer relationship
- Frontend tidak perlu mengirim customer_id untuk user role
