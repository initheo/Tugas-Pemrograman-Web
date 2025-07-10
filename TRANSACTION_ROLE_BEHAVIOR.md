# Transaction Form Role-Based Behavior

## 🎯 Perbedaan Behavior Admin vs User

### 👑 **ADMIN Role**
- **Customer Selection**: Harus memilih customer dari dropdown
- **Validation**: customer_id wajib diisi
- **Submit Data**: Mengirim customer_id yang dipilih ke backend
- **Access**: Bisa membuat transaksi untuk customer manapun

### 👤 **USER Role**  
- **Customer Selection**: Tidak ada dropdown (otomatis)
- **Validation**: Tidak validasi customer_id (backend handle otomatis)
- **Submit Data**: Tidak mengirim customer_id (backend ambil dari user.customer)
- **Access**: Hanya bisa membuat transaksi untuk diri sendiri

## 🔧 **Technical Implementation**

### Frontend Logic (TransactionForm.vue)
```javascript
// Validation
if (authStore.isAdmin && !form.value.customer_id) {
  errors.value.customer_id = 'Customer is required'
}

// Submit
if (authStore.isUser) {
  delete transactionData.customer_id // Backend will handle
}
```

### Backend Logic (TransactionController.php)
```php
// Validation
'customer_id' => 'required_if:role,admin|exists:customers,id',

// Processing
if ($user->isUser()) {
    $transactionData['customer_id'] = $user->customer->id;
}
```

## 📋 **Form Fields**

### Sama untuk Admin & User:
- ✅ Branch Store (dropdown)
- ✅ Service (dropdown) 
- ✅ Weight/Quantity (input)
- ✅ Transaction Date (date)
- ✅ Voucher (optional dropdown)
- ✅ Payment Method (dropdown)
- ✅ Notes (textarea)

### Berbeda:
- **Admin**: Customer dropdown (required)
- **User**: Customer info display (read-only)

## ⚡ **Auto Calculations**
- `base_amount = weight × service.price`
- `total_amount = base_amount - discount_amount`
- Real-time calculation saat user input weight atau pilih service

## 🛡️ **Error Handling**
- **Admin**: Error jika tidak pilih customer
- **User**: Warning jika tidak punya customer profile
- **Both**: Validasi standard untuk field wajib lainnya
