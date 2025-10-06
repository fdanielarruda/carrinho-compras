import CartPage from '@/pages/CartPage.vue'
import HomePage from '@/pages/HomePage.vue'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomePage
    },
    {
      path: '/carrinho',
      name: 'cart',
      component: CartPage
    }
  ],
})

export default router
