<script setup lang="ts">
import { ref, computed } from 'vue';

import CartHeader from '@/components/cart/CartHeader.vue';
import CartItem from '@/components/cart/CartItem.vue';
import CartSummary from '@/components/cart/CartSummary.vue';

const cartItems = ref([
  { id: 1, name: 'Ergo Lounge Chair', price: '$129.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Ergo Lounge Chair', quantity: 1, inStock: true, rawPrice: 129.00 },
  { id: 2, name: 'Wireless Headphones', price: '$178.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Wireless Headphones', quantity: 2, inStock: true, rawPrice: 89.00 },
]);

const subtotal = computed(() => {
  return cartItems.value.reduce((sum, item) => {
    const priceValue = item.rawPrice * item.quantity;
    return sum + priceValue;
  }, 0);
});

const formattedSubtotal = computed(() => {
  return `$${subtotal.value.toFixed(2)}`;
});

const updateItemQuantity = (id: number, newQuantity: number) => {
  const item = cartItems.value.find(i => i.id === id);
  if (item) {
    item.quantity = newQuantity;
    item.price = `$${(item.rawPrice * newQuantity).toFixed(2)}`;
  }
};

const removeItem = (id: number) => {
  cartItems.value = cartItems.value.filter(i => i.id !== id);
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 pt-3">
    <CartHeader />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
      <div class="lg:grid lg:grid-cols-3 lg:gap-8">

        <div class="lg:col-span-2">
          <CartItem v-for="item in cartItems" :key="item.id" :item="item" @update:quantity="updateItemQuantity"
            @remove="removeItem" />

          <div v-if="cartItems.length === 0" class="text-center text-gray-500 p-8 bg-white rounded-2xl shadow-sm">
            O carrinho está vazio
          </div>
        </div>

        <CartSummary :formatted-subtotal="formattedSubtotal" />

      </div>
    </main>
  </div>
</template>