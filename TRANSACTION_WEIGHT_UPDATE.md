# Transaction Weight & Service Integration Update

## Overview
Telah dilakukan update pada sistem untuk mendukung weight sebagai quantity dan integrasi dengan service untuk perhitungan base amount otomatis.

## Database Changes

### Table: transactions
Ditambahkan field baru:
- `service_id` (BIGINT UNSIGNED NULLABLE) - Foreign key ke table services
- `weight` (DECIMAL 8,2 NULLABLE) - Berat/quantity laundry

### Migration
File: `2025_07_10_214634_create_transactions_table.php`
```sql
$table->unsignedBigInteger('service_id')->nullable();
$table->decimal('weight', 8, 2)->nullable();
$table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
```

## Backend Changes

### Model: Transaction
- Ditambahkan field `service_id` dan `weight` ke `$fillable`
- Ditambahkan relationship `service()` ke model Service

### Controller: TransactionController
- Validasi untuk field `service_id` dan `weight`
- Menambahkan relationship loading untuk `service` di semua endpoint
- Support automatic calculation base_amount dari weight × service price

### Validation Rules
```php
'service_id' => 'nullable|exists:services,id',
'weight' => 'nullable|numeric|min:0',
```

## Frontend Changes

### TransactionForm.vue
#### Perubahan Utama:
1. **Service Selection Dropdown**
   - Dropdown untuk memilih service yang aktif
   - Menampilkan nama service, harga, dan durasi

2. **Weight Input Field**
   - Input untuk memasukkan berat/quantity
   - Validasi harus > 0

3. **Automatic Base Amount Calculation**
   - `calculateBaseAmount()` method
   - Formula: `base_amount = weight × service.price`
   - Real-time calculation saat weight atau service berubah

4. **Improved Validation**
   - Validasi service_id required
   - Validasi weight > 0
   - Error handling yang lebih baik

#### Computed Properties:
- `activeServices` - Filter service yang aktif
- `selectedService` - Service yang dipilih saat ini

#### Watch:
- Watch untuk service_id dan weight changes
- Trigger calculateBaseAmount() otomatis

### TransactionsPage.vue
#### Perubahan Tampilan:
1. **Kolom Baru di Tabel**
   - Kolom "Service" menampilkan nama service, harga per unit, durasi
   - Kolom "Weight" menampilkan berat dan kalkulasi (weight × price)

2. **Service Information Display**
   - Nama service
   - Harga per unit (Rp/kg)
   - Durasi estimasi
   - Formula perhitungan

## UI/UX Improvements

### TransactionForm
1. **Visual Calculation Display**
   ```
   Weight: [5] kg
   5 × Rp 10.000 = Rp 50.000
   ```

2. **Service Selection**
   ```
   Service: [Express Wash ▼]
   - Express Wash - Rp 10.000/kg (2-3 hours)
   ```

3. **Read-only Base Amount**
   - Field base_amount menjadi read-only
   - Calculated automatically
   - Helper text: "Calculated from: Weight × Service Price"

### TransactionsPage
1. **Enhanced Table View**
   - Service column shows service details
   - Weight column shows calculation breakdown
   - Better responsive design for mobile

## API Integration

### Endpoint Changes
Semua transaction endpoints sekarang include service relationship:
```php
->with(['customer', 'branchStore', 'voucher', 'user', 'service'])
```

### Service Store Integration
- `useServiceStore()` imported di TransactionForm
- `fetchServices()` dipanggil saat form initialization
- Service data tersedia untuk dropdown

## Configuration

### Form Initialization
```javascript
// Load services for all users
serviceStore.fetchServices()

// Service dropdown populated with active services
const activeServices = computed(() => {
  return serviceStore.services.filter(service => service.is_active) || []
})
```

### Calculation Logic
```javascript
const calculateBaseAmount = () => {
  if (selectedService.value && form.value.weight > 0) {
    form.value.base_amount = selectedService.value.price * form.value.weight
  } else {
    form.value.base_amount = 0
  }
  calculateTotal()
}
```

## Backward Compatibility

1. **Service ID Optional**: Field `service_id` nullable untuk support transaksi lama
2. **Weight Optional**: Field `weight` nullable untuk support transaksi lama
3. **Manual Base Amount**: Jika service_id atau weight kosong, masih bisa input manual

## Testing Guidelines

### Test Cases
1. **Create Transaction dengan Service**
   - Pilih service → Input weight → Verify base_amount calculation
   - Submit → Verify data tersimpan dengan benar

2. **Transaction List Display**
   - Verify service info ditampilkan
   - Verify weight calculation ditampilkan
   - Check responsive layout

3. **Edge Cases**
   - Service tanpa weight (compatibility)
   - Weight tanpa service (compatibility)
   - Service yang di-disable setelah transaksi dibuat

### Expected Behavior
1. Real-time calculation saat weight/service berubah
2. Validation error jika weight ≤ 0
3. Service dropdown hanya show active services
4. Table display service dan weight information

## Migration Notes

### Existing Data
- Transaksi existing akan memiliki `service_id` dan `weight` NULL
- Sistem tetap berfungsi normal untuk data lama
- Admin bisa update transaksi lama jika diperlukan

### Performance
- Lazy loading service relationship
- Efficient queries dengan proper indexing
- Minimal impact pada performance existing queries

## Future Enhancements

1. **Service Package Pricing**
   - Different pricing tiers based on weight ranges
   - Bulk discount calculations

2. **Weight Estimation**
   - AI-based weight estimation from item type
   - Historical weight data analysis

3. **Service Duration Tracking**
   - Real-time service duration monitoring
   - ETA calculations based on service type

---

**Status**: ✅ Completed
**Date**: July 10, 2025
**Version**: 1.2.0
