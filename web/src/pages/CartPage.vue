<script setup lang="ts">
import { onMounted, computed, watch, ref } from 'vue';
import { useCartStore } from '@/stores/cartStore';
import { useRouter } from 'vue-router';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';

import CartHeader from '@/components/cart/CartHeader.vue';
import CartItem from '@/components/cart/CartItem.vue';
import CartSummary from '@/components/cart/CartSummary.vue';

const cartStore = useCartStore();
const router = useRouter();

const showSuccessModal = ref(false);

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

const handleCheckout = async () => {
  await cartStore.finishCheckout();
  showSuccessModal.value = true;
};

const goToHome = () => {
  showSuccessModal.value = false;
  router.push('/');
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 pt-3">
    <CartHeader />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
      <div v-if="cartStore.items.length === 0" class="text-center text-gray-500 p-8 bg-white rounded-2xl shadow-sm">
        O carrinho está vazio
      </div>

      <div class="lg:grid lg:grid-cols-3 lg:gap-8" v-else>
        <div class="lg:col-span-2 space-y-4">
          <CartItem v-for="item in cartStore.items" :key="item.id"
            :item="{ ...item, price: item.unit_price * item.quantity }" @update:quantity="updateItemQuantity"
            @remove="removeItem" />
        </div>

        <CartSummary :subtotal="subtotal" :total-price="cartStore.totalPrice" :is-loading="cartStore.isLoading"
          @update:payment="cartStore.setPaymentOptions" @checkout="handleCheckout" />
      </div>
    </main>

    <div v-if="showSuccessModal"
      class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
      <div class="bg-white p-8 rounded-xl shadow-2xl text-center max-w-sm w-full transform transition-all">
        <CheckCircleIcon class="w-16 h-16 text-green-600 mx-auto mb-6" />

        <h3 class="text-2xl font-extrabold text-gray-900 mb-3">Pedido Realizado com Sucesso!</h3>
        <p class="text-gray-600 mb-8">
          Seu pedido foi processado, volte a nossa página inicial para escolher novos produtos.
        </p>

        <button @click="goToHome"
          class="w-full px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 ease-in-out shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Voltar para a Home
        </button>
      </div>
    </div>
  </div>
</template>
