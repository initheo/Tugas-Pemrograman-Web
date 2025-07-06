Nama Kelompok:

- 3012310010 Faiz Nurullah
- 3012310023 Muhammad Muqoffin Nuha
- 3012310005 Ari Setia Hinanda

Nama Aplikasi: LaundrEase
Deskripsi Aplikasi: Aplikasi laundrEase adalah aplikasi laundry berbasis web yang memudahkan pengguna untuk melakukan pemesanan laundry secara online. Pengguna dapat memilih jenis layanan laundry, mengatur waktu pengambilan dan pengantaran, serta melakukan pembayaran secara online. Aplikasi ini juga dilengkapi dengan fitur notifikasi untuk mengingatkan pengguna tentang status pesanan mereka.
Aplikasi ini bertujuan untuk memberikan kemudahan dan kenyamanan bagi pengguna dalam menggunakan layanan laundry.

# LaundrEase - Frontend & Backend Integration

## Overview
LaundreEase adalah aplikasi manajemen laundry yang terdiri dari frontend Vue.js dan backend Laravel. Aplikasi ini telah diintegrasikan dengan autentikasi, state management menggunakan Pinia, dan komunikasi API yang lengkap.

## Tech Stack

### Frontend
- **Vue.js 3** - Progressive JavaScript Framework
- **Vite** - Build tool dan development server
- **Pinia** - State management untuk Vue
- **Vue Router** - Client-side routing
- **Axios** - HTTP client untuk API calls
- **TailwindCSS** - Utility-first CSS framework

### Backend
- **Laravel** - PHP Framework
- **Laravel Sanctum** - Authentication system
- **MySQL** - Database

## Features

### Authentication
- Login system dengan Laravel Sanctum
- Token-based authentication
- Route guards untuk proteksi halaman
- Auto-redirect untuk unauthorized access

### Modules
1. **Dashboard** - Overview statistik aplikasi
2. **Customers** - Manajemen data pelanggan
3. **Branches** - Manajemen cabang laundry
4. **Vouchers** - Manajemen voucher diskon
5. **Transactions** - Manajemen transaksi (dalam pengembangan)

### API Integration
- RESTful API dengan Laravel
- CRUD operations untuk semua modul
- Error handling yang konsisten
- Loading states dan user feedback

## Setup Instructions

### Prerequisites
- Node.js (v16 atau lebih baru)
- PHP (v8.0 atau lebih baru)
- Composer
- MySQL database

### Backend Setup
1. Navigate ke directory backend:
   ```bash
   cd backend-apps
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Setup environment file:
   ```bash
   cp .env.example .env
   ```

4. Configure database di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laundrease
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

### Frontend Setup
Dependencies sudah terinstall via npm.

## Running the Application

### Development Mode

#### Option 1: Run Both (Recommended)
```bash
npm run dev:full
```
Ini akan menjalankan backend Laravel di port 8000 dan frontend Vite di port 5173 secara bersamaan.

#### Option 2: Run Separately
Terminal 1 (Backend):
```bash
npm run dev:backend
```

Terminal 2 (Frontend):
```bash
npm run dev
```

## API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout (requires auth)

### Customers
- `GET /api/customers` - Get all customers
- `POST /api/customers` - Create customer
- `PUT /api/customers/{id}` - Update customer
- `DELETE /api/customers/{id}` - Delete customer

### Branch Stores
- `GET /api/branchstores` - Get all branches
- `POST /api/branchstores` - Create branch
- `PUT /api/branchstores/{id}` - Update branch
- `DELETE /api/branchstores/{id}` - Delete branch

### Vouchers
- `GET /api/vouchers` - Get all vouchers
- `POST /api/vouchers` - Create voucher
- `PUT /api/vouchers/{id}` - Update voucher
- `DELETE /api/vouchers/{id}` - Delete voucher

## State Management dengan Pinia

### Stores Available
- **authStore** - Authentication state
- **customerStore** - Customer data management
- **branchStore** - Branch data management
- **voucherStore** - Voucher data management

### Usage Example
```javascript
import { useCustomerStore } from '@/stores/customerStore'

const customerStore = useCustomerStore()
await customerStore.fetchCustomers()
```

## Authentication Flow
1. User mengakses halaman login (`/login`)
2. Input credentials dan submit form
3. Frontend mengirim request ke `/api/login`
4. Backend memvalidasi dan mengembalikan token
5. Token disimpan di localStorage
6. User diredirect ke dashboard

## Troubleshooting

### Common Issues
1. **CORS Errors**: Pastikan backend CORS configuration sudah benar
2. **401 Unauthorized**: Check apakah token valid
3. **API Not Found**: Pastikan backend Laravel berjalan di port 8000

## Original Installation Guide (Legacy)

# LaundrEase - Aplikasi Laundry Online

## Panduan Instalasi

### Prasyarat

- Node.js versi 18.0.0 atau lebih baru
- NPM atau PNPM sebagai package manager
- Git untuk clone repository

### Langkah Instalasi

1. Clone repository

```bash
git clone <url-repository>
cd Tugas-Pemrograman-Web
```

2. Install dependencies

```bash
npm install
# atau jika menggunakan pnpm
pnpm install
```

3. Jalankan aplikasi dalam mode development

```bash
npm run dev
# atau
pnpm dev
```

4. Build untuk production

```bash
npm run build
# atau
pnpm build
```

5. Preview hasil build

```bash
npm run preview
# atau
pnpm preview
```
