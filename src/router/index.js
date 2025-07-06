import { createRouter, createWebHistory } from 'vue-router';
import DashboardPage from '../pages/DashboardPage.vue';
import CustomersPage from '../pages/CustomersPage.vue';
import BranchesPage from '../pages/BranchesPage.vue';
import VouchersPage from '../pages/VouchersPage.vue';
import TransactionsPage from '@/pages/TransactionsPage.vue';


const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: DashboardPage,
    },
    {
      path: '/customers',
      component: CustomersPage,
    },
    {
      path: '/branches',
      component: BranchesPage,
    },
    {
      path: '/vouchers',
      component: VouchersPage,
    },
    {
      path: '/transactions',
      component: TransactionsPage,
    },
  ],
});

export default router;