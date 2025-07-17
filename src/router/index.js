import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/authStore';
import { authService } from '../services/authService';
import DashboardPage from '../pages/DashboardPage.vue';
import CustomersPage from '../pages/CustomersPage.vue';
import BranchesPage from '../pages/BranchesPage.vue';
import VouchersPage from '../pages/VouchersPage.vue';
import TransactionsPage from '../pages/TransactionsPage.vue';
import ServicesPage from '../pages/ServicesPage.vue';
import ProfilePage from '../pages/ProfilePage.vue';
import SettingsPage from '../pages/SettingsPage.vue';
import LoginPage from '../pages/LoginPage.vue';
import AboutView from '../views/AboutView.vue'
import ContactView from '../views/ContactView.vue'
import FaqView from '../views/FaqView.vue'
import HomeView from '../views/HomeView.vue'
import PricingView from '../views/PricingView.vue'
import RegisterView from '../views/RegisterView.vue'
import ServicesView from '../views/ServicesView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
     {
    path: '/',
    name: 'Home',
    component: HomeView,
    meta: {
      title: 'Beranda'
    }
  },
    {
      path: '/about',
      name: 'About',
      component: AboutView,
      meta: {
        title: 'Tentang Kami'
      }
    },
    {
      path: '/services',
      name: 'Services',
      component: ServicesView,
      meta: {
        title: 'Layanan'
      }
    },
    {
      path: '/pricing',
      name: 'Pricing',
      component: PricingView,
      meta: {
        title: 'Harga'
      }
    },
    {
      path: '/faq',
      name: 'FAQ',
      component: FaqView,
      meta: {
        title: 'FAQ'
      }
    },
    {
      path: '/contact',
      name: 'Contact',
      component: ContactView,
      meta: {
        title: 'Kontak'
      }
    },
    {
      path: '/login',
      name: 'Login',
      component: LoginPage,
      meta: { requiresGuest: true }
    },
    {
      path: '/register',
      name: 'Register',
      component: RegisterView,
      meta: { requiresGuest: true }
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: DashboardPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/customers',
      name: 'Customers',
      component: CustomersPage,
      meta: { requiresAuth: true, requiresAdmin: true }
    },
    {
      path: '/branches',
      name: 'Branches',
      component: BranchesPage,
      meta: { requiresAuth: true, requiresAdmin: true }
    },
    {
      path: '/vouchers',
      name: 'Vouchers',
      component: VouchersPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/services-management',
      name: 'ServicesManagement',
      component: ServicesPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/transactions',
      name: 'Transactions',
      component: TransactionsPage,
      meta: { requiresAuth: true }
    },
    {
      path: '/profile',
      name: 'Profile',
      component: ProfilePage,
      meta: { requiresAuth: true }
    },
    {
      path: '/settings',
      name: 'Settings',
      component: SettingsPage,
      meta: { requiresAuth: true, requiresAdmin: true }
    },
  ],
});

// Navigation guard for authentication
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  console.log('Navigation guard:', {
    to: to.path,
    from: from.path,
    isAuthenticated: authStore.isAuthenticated
  })

  // Initialize auth state from localStorage if not already done
  if (!authStore.isAuthenticated) {
    authStore.initializeAuth();
    console.log('Auth initialized in router guard:', authStore.isAuthenticated)
  }

  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const requiresGuest = to.matched.some(record => record.meta.requiresGuest);
  const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin);

  if (requiresAuth && !authStore.isAuthenticated) {
    console.log('Redirecting to login - auth required but not authenticated')
    // Redirect to login if authentication is required but user is not authenticated
    next({ 
      path: '/login',
      query: { redirect: to.fullPath }
    });
  } else if (requiresGuest && authStore.isAuthenticated) {
    console.log('Redirecting to dashboard - user already authenticated')
    // Redirect to dashboard if user is already authenticated and trying to access guest pages
    next('/dashboard');
  } else if (requiresAdmin && !authService.isAdmin()) {
    console.log('Redirecting to dashboard - admin access required')
    // Redirect to dashboard if admin access is required but user is not admin
    next('/dashboard');
  } else {
    console.log('Navigation allowed')
    next();
  }
});

export default router;