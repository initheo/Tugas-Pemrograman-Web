# LaundreEase - Frontend & Backend Integration

Aplikasi manajemen laundry dengan frontend Vue.js dan backend Laravel yang telah terintegrasi.

## 🚀 Fitur

- **Authentication**: Login/logout dengan Laravel Sanctum
- **Customer Management**: CRUD operations untuk customer
- **Branch Management**: CRUD operations untuk cabang toko
- **Voucher Management**: CRUD operations untuk voucher
- **Dashboard**: Statistik dan overview bisnis
- **Responsive Design**: UI yang responsive dengan Tailwind CSS

## 📋 Prerequisites

Pastikan anda sudah menginstall:
- PHP >= 8.0
- Composer
- Node.js >= 16
- pnpm atau npm

## ⚙️ Installation

### 1. Clone dan Setup Dependencies

```bash
# Install frontend dependencies
pnpm install

# Install backend dependencies
cd backend-apps
composer install
```

### 2. Setup Environment Backend

```bash
cd backend-apps

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database dan migrasi
php artisan migrate

# (Optional) Seed data
php artisan db:seed
```

### 3. Konfigurasi Database

Edit file `backend-apps/.env` sesuai dengan konfigurasi database anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundrease_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup CORS (Backend)

Pastikan konfigurasi CORS di `backend-apps/config/cors.php` sudah benar:

```php
'allowed_origins' => ['http://localhost:5173'], // Frontend URL
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

## 🏃‍♂️ Running the Application

### Option 1: Run Both Services Together (Recommended)

```bash
# Install concurrently untuk run parallel
pnpm install

# Run frontend dan backend bersamaan
pnpm run dev:full
```

### Option 2: Run Services Separately

```bash
# Terminal 1 - Run backend
cd backend-apps
php artisan serve

# Terminal 2 - Run frontend
pnpm run dev
```

## 📡 API Endpoints

Backend menyediakan API endpoints berikut:

### Authentication
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (requires auth)

### Customers
- `GET /api/customers` - Get all customers
- `POST /api/customers` - Create customer
- `GET /api/customers/{id}` - Get customer by ID
- `PUT /api/customers/{id}` - Update customer
- `DELETE /api/customers/{id}` - Delete customer

### Branch Stores
- `GET /api/branchstores` - Get all branches
- `POST /api/branchstores` - Create branch
- `GET /api/branchstores/{id}` - Get branch by ID
- `PUT /api/branchstores/{id}` - Update branch
- `DELETE /api/branchstores/{id}` - Delete branch

### Vouchers
- `GET /api/vouchers` - Get all vouchers
- `POST /api/vouchers` - Create voucher
- `GET /api/vouchers/{id}` - Get voucher by ID
- `PUT /api/vouchers/{id}` - Update voucher
- `DELETE /api/vouchers/{id}` - Delete voucher

## 🎯 Frontend Features

### State Management
- Menggunakan **Pinia** untuk state management
- Store terpisah untuk Auth, Customer, Branch, dan Voucher
- Automatic token management dan auth guards

### Routing
- Vue Router dengan authentication guards
- Protected routes untuk halaman authenticated
- Automatic redirect ke login jika belum authenticated

### Components
- Reusable form components
- Modal components
- Table dengan sorting dan pagination
- Loading states dan error handling

## 🔧 Development

### Frontend Structure
```
src/
├── components/          # Reusable components
├── pages/              # Page components
├── router/             # Vue Router configuration
├── services/           # API services
├── stores/             # Pinia stores
└── assets/             # Static assets
```

### Backend Structure
```
backend-apps/
├── app/
│   ├── Http/Controllers/API/    # API Controllers
│   └── Models/                  # Eloquent Models
├── routes/api.php              # API Routes
└── config/cors.php             # CORS Configuration
```

## 🐛 Troubleshooting

### Common Issues

1. **CORS Error**
   - Pastikan `allowed_origins` di `config/cors.php` sudah benar
   - Restart backend server setelah perubahan config

2. **Authentication Error**
   - Pastikan Laravel Sanctum sudah terkonfigurasi dengan benar
   - Check apakah token disimpan di localStorage

3. **Database Connection Error**
   - Pastikan konfigurasi database di `.env` sudah benar
   - Pastikan database sudah dibuat

4. **404 API Error**
   - Pastikan backend server berjalan di port 8000
   - Check proxy configuration di `vite.config.js`

## 📝 Default Login Credentials

Jika anda sudah menjalankan seeder, gunakan kredensial default:
- Email: `admin@laundrease.com`
- Password: `password`

## 🔄 API Testing

Anda bisa test API menggunakan tools seperti Postman atau Insomnia:

1. Login dulu untuk mendapatkan token
2. Gunakan token di header: `Authorization: Bearer <token>`
3. Test CRUD operations untuk setiap endpoint

## 📞 Support

Jika ada masalah atau pertanyaan, silakan buat issue di repository ini.
