# LaundreEase - Frontend Backend Integration

Aplikasi manajemen laundry modern dengan frontend Vue.js dan backend Laravel yang telah terintegrasi.

## 🚀 Quick Start

### Prerequisites
- Node.js (v16 atau lebih baru)
- PHP (v8.1 atau lebih baru)
- Composer
- MySQL/MariaDB

### Installation

1. **Install Frontend Dependencies**
   ```bash
   npm install
   # atau
   pnpm install
   ```

2. **Install Backend Dependencies**
   ```bash
   cd backend-apps
   composer install
   ```

3. **Setup Environment**
   ```bash
   cd backend-apps
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   - Buat database MySQL baru
   - Update konfigurasi database di `backend-apps/.env`
   - Jalankan migrasi:
   ```bash
   cd backend-apps
   php artisan migrate --seed
   ```

### Running the Application

#### Option 1: Menggunakan Script (Recommended)
```bash
# Windows
./start-dev.bat

# Linux/Mac
./start-dev.sh
```

#### Option 2: Manual
```bash
# Terminal 1 - Backend
cd backend-apps
php artisan serve --port=8000

# Terminal 2 - Frontend  
npm run dev
```

Aplikasi akan berjalan di:
- Frontend: http://localhost:5173
- Backend API: http://localhost:8000

## 🏗️ Architecture

### Frontend (Vue.js 3)
- **Framework**: Vue.js 3 dengan Composition API
- **State Management**: Pinia
- **Routing**: Vue Router 4
- **HTTP Client**: Axios
- **Styling**: Tailwind CSS
- **Build Tool**: Vite

### Backend (Laravel)
- **Framework**: Laravel 9+
- **Authentication**: Laravel Sanctum
- **API**: RESTful API
- **Database**: MySQL

### Integration Features

#### 🔐 Authentication
- Login/logout dengan Laravel Sanctum
- Token-based authentication
- Route guards untuk proteksi halaman
- Auto-redirect untuk user yang sudah/belum login

#### 📊 Data Management
- **Customers**: CRUD operations untuk manajemen pelanggan
- **Branches**: CRUD operations untuk manajemen cabang
- **Vouchers**: CRUD operations untuk manajemen voucher
- **Transactions**: Sistem transaksi laundry

#### 🔧 API Integration
- Centralized API service dengan interceptors
- Error handling global
- Loading states
- CORS configuration

## 📁 Project Structure

```
├── src/
│   ├── components/          # Vue components
│   │   ├── BranchForm.vue
│   │   ├── CustomerForm.vue
│   │   └── VoucherForm.vue
│   ├── pages/              # Page components
│   │   ├── DashboardPage.vue
│   │   ├── CustomersPage.vue
│   │   ├── BranchesPage.vue
│   │   ├── VouchersPage.vue
│   │   └── LoginPage.vue
│   ├── services/           # API services
│   │   ├── api.js          # Axios configuration
│   │   ├── authService.js  # Authentication API
│   │   ├── customerService.js
│   │   ├── branchService.js
│   │   └── voucherService.js
│   ├── stores/             # Pinia stores
│   │   ├── authStore.js
│   │   ├── customerStore.js
│   │   ├── branchStore.js
│   │   └── voucherStore.js
│   └── router/             # Vue Router configuration
└── backend-apps/           # Laravel backend
    ├── app/
    ├── routes/api.php      # API routes
    ├── config/cors.php     # CORS configuration
    └── ...
```

## 🔌 API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout

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

## 🎯 Features

### ✅ Implemented
- ✅ Authentication system
- ✅ Customer management
- ✅ Branch management  
- ✅ Voucher management
- ✅ Responsive dashboard
- ✅ State management with Pinia
- ✅ API integration
- ✅ Loading states
- ✅ Error handling

### 🚧 To Be Implemented
- Transaction management
- User management
- Reporting system
- Real-time notifications
- File upload for images

## 🛠️ Development

### Adding New Features
1. Create API endpoint di Laravel
2. Buat service di `src/services/`
3. Buat store di `src/stores/`
4. Buat component/page di `src/components/` atau `src/pages/`
5. Update router jika perlu

### Environment Variables
Frontend menggunakan Vite proxy untuk development. Untuk production, update `API_BASE_URL` di `src/services/api.js`.

## 📝 Notes

- Pastikan backend Laravel berjalan di port 8000
- Frontend development server berjalan di port 5173
- CORS sudah dikonfigurasi untuk development
- Authentication menggunakan localStorage untuk menyimpan token
- Semua API calls menggunakan Bearer token authentication

## 🤝 Contributing

1. Fork the project
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is private and confidential.
