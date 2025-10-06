<script setup lang="ts">
import { onMounted, computed, watch } from 'vue';
import { useCartStore } from '@/stores/cartStore';

import CartHeader from '@/components/cart/CartHeader.vue';
import CartItem from '@/components/cart/CartItem.vue';
import CartSummary from '@/components/cart/CartSummary.vue';

const cartStore = useCartStore();

onMounted(() => {
  cartStore.calculateTotal();
});

const subtotal = computed(() => {
  return cartStore.items.reduce((sum, item) => {
    return sum + (item.unit_price * item.quantity);
  }, 0);
});

const updateItemQuantity = (id: number, newQuantity: number) => {
  cartStore.updateItemQuantity(id, newQuantity);
};

const removeItem = (id: number) => {
  cartStore.removeProductFromCart(id);
};

watch(
  () => cartStore.items.length,
  () => cartStore.calculateTotal(),
  { deep: true }
);

</script>

<template>
  <div class="min-h-screen bg-gray-50 pt-3">
    <CartHeader />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
      <div class="lg:grid lg:grid-cols-3 lg:gap-8">

        <div class="lg:col-span-2">
          <CartItem v-for="item in cartStore.items" :key="item.id"
            :item="{ ...item, price: `$${(item.unit_price * item.quantity).toFixed(2)}` }"
            @update:quantity="updateItemQuantity" @remove="removeItem" />

          <div v-if="cartStore.items.length === 0" class="text-center text-gray-500 p-8 bg-white rounded-2xl shadow-sm">
            O carrinho está vazio
          </div>
        </div>

        <CartSummary :subtotal="subtotal" :total-price="cartStore.totalPrice" :is-loading="cartStore.isLoading"
          @update:payment="cartStore.setPaymentOptions" />

      </div>
    </main>
  </div>
</template>