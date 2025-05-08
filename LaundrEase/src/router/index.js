import { createRouter, createWebHistory } from 'vue-router'
import AboutView from '../views/AboutView.vue'
import ContactView from '../views/ContactView.vue'
import FaqView from '../views/FaqView.vue'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import PricingView from '../views/PricingView.vue'
import ServicesView from '../views/ServicesView.vue'


const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    component: AboutView
  },
  {
    path: '/contact',
    name: 'contact',
    component: ContactView
  },
  {
    path: '/faq',
    name: 'faq',
    component: FaqView
  },
  {
    path: '/services',
    name: 'services',
    component: ServicesView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/pricing',
    name: 'pricing',
    component: PricingView
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router

