import CartView from '@/pages/CartView.vue'
import HomeView from '@/pages/HomeView.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/carrinho',
      name: 'cart',
      component: CartView
    }
  ],
})

export default router
