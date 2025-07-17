# Navigation Structure Update

## Overview
Struktur navigasi telah diubah untuk memisahkan navigasi landing page dari navigasi dashboard. Sekarang navbar hanya menampilkan menu landing page, sedangkan navigasi dashboard menggunakan sidebar.

## Changes Made

### 1. Header.vue Modifications
- **Removed** `adminNavItems` dan `userNavItems` dari Header component
- **Modified** `navItems` computed property untuk selalu menampilkan `publicNavItems`
- Navbar sekarang hanya fokus pada halaman landing page (public pages)

### 2. New Components Created

#### Sidebar.vue
- **Purpose**: Menangani navigasi untuk authenticated users dalam dashboard
- **Features**:
  - Collapsible sidebar dengan toggle button
  - Role-based navigation items (admin vs user)
  - User profile info section
  - Icons untuk setiap menu item
  - Responsive design with mobile overlay
  - Logout functionality

#### DashboardLayout.vue
- **Purpose**: Layout wrapper untuk semua halaman dashboard
- **Features**:
  - Integrates Sidebar component
  - Top header dengan page title
  - Breadcrumb navigation
  - Quick actions buttons
  - Responsive margin adjustments
  - Proper spacing dan transitions

#### DashboardView.vue
- **Purpose**: Contoh implementasi dashboard menggunakan DashboardLayout
- **Features**:
  - Welcome section
  - Stats grid dengan metrics
  - Recent activities feed
  - Quick actions panel
  - Role-based content display

## Navigation Items Configuration

### Public Navigation (Header)
```javascript
const publicNavItems = [
  { path: '/', label: 'Beranda' },
  { path: '/about', label: 'Tentang Kami' },
  { path: '/services', label: 'Layanan' },
  { path: '/pricing', label: 'Harga' },
  { path: '/faq', label: 'FAQ' },
  { path: '/contact', label: 'Kontak' }
];
```

### Admin Navigation (Sidebar)
```javascript
const adminNavItems = [
  { path: '/dashboard', label: 'Dashboard', icon: 'fas fa-tachometer-alt' },
  { path: '/customers', label: 'Customers', icon: 'fas fa-users' },
  { path: '/branches', label: 'Branches', icon: 'fas fa-map-marker-alt' },
  { path: '/services-management', label: 'Services', icon: 'fas fa-cogs' },
  { path: '/vouchers', label: 'Vouchers', icon: 'fas fa-ticket-alt' },
  { path: '/transactions', label: 'Transactions', icon: 'fas fa-receipt' },
  { path: '/settings', label: 'Settings', icon: 'fas fa-cog' }
];
```

### User Navigation (Sidebar)
```javascript
const userNavItems = [
  { path: '/dashboard', label: 'Dashboard', icon: 'fas fa-tachometer-alt' },
  { path: '/services-management', label: 'Services', icon: 'fas fa-cogs' },
  { path: '/transactions', label: 'Transaksi Saya', icon: 'fas fa-receipt' },
  { path: '/vouchers', label: 'Voucher', icon: 'fas fa-ticket-alt' }
];
```

## Usage Instructions

### For Dashboard Pages
Wrap your dashboard pages dengan `DashboardLayout`:

```vue
<template>
  <DashboardLayout title="Your Page Title" :showBreadcrumb="true">
    <!-- Your page content here -->
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from '../components/DashboardLayout.vue';
</script>
```

### For Landing Pages
Continue using the normal layout dengan Header component yang sudah dimodifikasi.

## Benefits

1. **Separation of Concerns**: Landing page navigation terpisah dari dashboard navigation
2. **Better UX**: Sidebar memberikan akses cepat ke semua dashboard features
3. **Responsive Design**: Sidebar responsive dengan mobile overlay
4. **Collapsible**: Sidebar dapat di-collapse untuk menghemat space
5. **Role-based**: Navigation items berubah berdasarkan user role
6. **Consistent Layout**: Semua dashboard pages menggunakan layout yang konsisten

## Next Steps

1. Update semua existing dashboard pages untuk menggunakan `DashboardLayout`
2. Add router guards untuk memastikan hanya authenticated users yang dapat mengakses dashboard
3. Implement actual API calls dalam dashboard components
4. Add more dashboard-specific features seperti notifications, search, etc.

## Files Modified/Created

### Modified:
- `src/components/Header.vue`

### Created:
- `src/components/Sidebar.vue`
- `src/components/DashboardLayout.vue`
- `src/views/DashboardView.vue`
- `NAVIGATION_UPDATE.md` (this file)
