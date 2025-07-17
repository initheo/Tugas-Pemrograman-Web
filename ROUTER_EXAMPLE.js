// Example router configuration for the new navigation structure
// This shows how to properly configure routes for the new sidebar-based navigation

import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/authStore';
import { authService } from '../services/authService';

// Public/Landing Page Views
import HomeView from '../views/HomeView.vue';
import AboutView from '../views/AboutView.vue';
import ContactView from '../views/ContactView.vue';
import FaqView from '../views/FaqView.vue';
import PricingView from '../views/PricingView.vue';
import ServicesView from '../views/ServicesView.vue';
import RegisterView from '../views/RegisterView.vue';
import LoginPage from '../pages/LoginPage.vue';

// Dashboard Views (using DashboardLayout)
import DashboardView from '../views/DashboardView.vue';
import TransactionsView from '../views/TransactionsView.vue';
// Import other dashboard views as needed

const router = createRouter({
  history: createWebHistory(),
  routes: [
    // Public Routes (Landing Pages) - These use Header navigation
    {
      path: '/',
      name: 'Home',
      component: HomeView,
      meta: {
        title: 'Beranda',
        layout: 'public'
      }
    },
    {
      path: '/about',
      name: 'About',
      component: AboutView,
      meta: {
        title: 'Tentang Kami',
        layout: 'public'
      }
    },
    {
      path: '/services',
      name: 'Services',
      component: ServicesView,
      meta: {
        title: 'Layanan',
        layout: 'public'
      }
    },
    {
      path: '/pricing',
      name: 'Pricing',
      component: PricingView,
      meta: {
        title: 'Harga',
        layout: 'public'
      }
    },
    {
      path: '/faq',
      name: 'FAQ',
      component: FaqView,
      meta: {
        title: 'FAQ',
        layout: 'public'
      }
    },
    {
      path: '/contact',
      name: 'Contact',
      component: ContactView,
      meta: {
        title: 'Kontak',
        layout: 'public'
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: LoginPage,
      meta: {
        title: 'Login',
        layout: 'public'
      }
    },
    {
      path: '/register',
      name: 'Register',
      component: RegisterView,
      meta: {
        title: 'Register',
        layout: 'public'
      }
    },

    // Dashboard Routes - These use Sidebar navigation via DashboardLayout
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: DashboardView,
      meta: {
        title: 'Dashboard',
        layout: 'dashboard',
        requiresAuth: true
      }
    },
    {
      path: '/transactions',
      name: 'Transactions',
      component: TransactionsView,
      meta: {
        title: 'Transactions',
        layout: 'dashboard',
        requiresAuth: true
      }
    },
    {
      path: '/customers',
      name: 'Customers',
      component: () => import('../views/CustomersView.vue'),
      meta: {
        title: 'Customers',
        layout: 'dashboard',
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/branches',
      name: 'Branches',
      component: () => import('../views/BranchesView.vue'),
      meta: {
        title: 'Branches',
        layout: 'dashboard',
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/services-management',
      name: 'ServicesManagement',
      component: () => import('../views/ServicesManagementView.vue'),
      meta: {
        title: 'Services Management',
        layout: 'dashboard',
        requiresAuth: true
      }
    },
    {
      path: '/vouchers',
      name: 'Vouchers',
      component: () => import('../views/VouchersView.vue'),
      meta: {
        title: 'Vouchers',
        layout: 'dashboard',
        requiresAuth: true
      }
    },
    {
      path: '/settings',
      name: 'Settings',
      component: () => import('../views/SettingsView.vue'),
      meta: {
        title: 'Settings',
        layout: 'dashboard',
        requiresAuth: true,
        requiresAdmin: true
      }
    },
    {
      path: '/profile',
      name: 'Profile',
      component: () => import('../views/ProfileView.vue'),
      meta: {
        title: 'Profile',
        layout: 'dashboard',
        requiresAuth: true
      }
    },

    // 404 Route
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component: () => import('../views/NotFoundView.vue'),
      meta: {
        title: 'Page Not Found',
        layout: 'public'
      }
    }
  ]
});

// Navigation Guards
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  
  // Set page title
  document.title = to.meta.title ? `${to.meta.title} - LaundrEase` : 'LaundrEase';
  
  // Check authentication
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login');
    return;
  }
  
  // Check admin access
  if (to.meta.requiresAdmin && !authService.isAdmin()) {
    next('/dashboard');
    return;
  }
  
  // Redirect authenticated users away from login/register
  if ((to.name === 'Login' || to.name === 'Register') && authStore.isAuthenticated) {
    next('/dashboard');
    return;
  }
  
  next();
});

export default router;
