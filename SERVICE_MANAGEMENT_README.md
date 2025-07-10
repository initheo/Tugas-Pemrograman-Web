# Service Management - CRUD Features

## Overview
Fitur CRUD Service/Layanan telah dibuat untuk aplikasi frontend Vue.js dan backend Laravel API. Fitur ini memungkinkan admin untuk mengelola layanan laundry dan user untuk melihat layanan yang tersedia.

## Files Created/Modified

### Frontend (Vue.js)
1. **Components:**
   - `src/components/ServiceForm.vue` - Form untuk create/edit service
   
2. **Pages:**
   - `src/pages/ServicesPage.vue` - Halaman utama untuk manajemen service
   
3. **Store:**
   - `src/stores/serviceStore.js` - Pinia store untuk state management service
   
4. **Router:**
   - `src/router/index.js` - Ditambahkan route `/services-management`
   
5. **Navigation:**
   - `src/components/Header.vue` - Ditambahkan link Services ke navigation

### Backend (Laravel)
1. **Controller:**
   - `backend-apps/app/Http/Controllers/API/ServiceController.php` - Updated untuk support is_active field
   
2. **Model:**
   - `backend-apps/app/Models/Service.php` - Updated dengan accessor/mutator untuk is_active
   
3. **Routes:**
   - `backend-apps/routes/api.php` - Route resource services sudah ada

## Features

### Admin View
- **Create Service:** Form untuk menambah layanan baru
- **Read Services:** Tabel dengan pagination, search, dan filter
- **Update Service:** Edit layanan yang sudah ada
- **Delete Service:** Hapus layanan
- **Toggle Status:** Aktifkan/nonaktifkan layanan
- **Search & Filter:** Pencarian berdasarkan nama, deskripsi, service code
- **Pagination:** Pagination dengan kontrol items per page

### User View
- **Browse Services:** Grid view layanan yang aktif
- **Search Services:** Pencarian layanan untuk user
- **Service Details:** Informasi harga dan durasi

## API Endpoints

```
GET    /api/services           - List all services
POST   /api/services           - Create new service
GET    /api/services/{id}      - Get specific service
PUT    /api/services/{id}      - Update service
DELETE /api/services/{id}      - Delete service
```

## Service Data Structure

```javascript
{
  id: Number,
  name: String,
  description: String,
  price: Number,
  duration: String,
  service_code: String,
  status: String ('active'|'inactive'),
  is_active: Boolean, // Computed from status
  created_at: String,
  updated_at: String
}
```

## Usage

### Accessing Service Management
1. Login sebagai admin atau user
2. Akses melalui navigation menu "Services"
3. URL: `/services-management`

### Admin Functions
- **Add Service:** Click "Add Service" button
- **Edit Service:** Click edit icon pada tabel
- **Delete Service:** Click delete icon pada tabel
- **Toggle Status:** Click status badge untuk toggle active/inactive
- **Search:** Gunakan search box untuk mencari layanan
- **Filter:** Filter berdasarkan status (All/Active/Inactive)

### User Functions
- **Browse:** Lihat semua layanan aktif dalam grid layout
- **Search:** Cari layanan yang diinginkan
- **Select:** Click "Select Service" untuk memilih layanan

## Authentication & Authorization
- **Admin:** Full CRUD access ke semua layanan
- **User:** Read-only access ke layanan aktif saja
- **Guest:** Tidak ada akses ke halaman management

## Error Handling
- Form validation dengan error messages
- API error handling dengan try-catch
- Loading states untuk UX yang lebih baik
- Confirmation dialog untuk delete operations

## Styling
- Responsive design dengan Tailwind CSS
- Hover effects dan transitions
- Loading animations
- Consistent color scheme dengan aplikasi

## Notes
- Field `unit` dihapus karena tidak ada di database backend
- Field `status` di backend dikonversi ke `is_active` boolean di frontend
- Pagination menggunakan client-side pagination
- Search dan filter juga client-side untuk performa yang lebih baik
