<script setup lang="ts">
import { ref, computed } from 'vue';
import { ArrowLeftIcon, LockClosedIcon } from '@heroicons/vue/24/outline';
import CartItem from '@/components/CartItem.vue';

const cartItems = ref([
  { id: 1, name: 'Ergo Lounge Chair', price: '$129.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Ergo Lounge Chair', quantity: 1, inStock: true, rawPrice: 129.00 },
  { id: 2, name: 'Wireless Headphones', price: '$178.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Wireless Headphones', quantity: 2, inStock: true, rawPrice: 89.00 }, // Corrigido para corresponder à imagem (2 x $89.00 = $178.00)
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

const selectedPayment = ref('Pix');
const installments = ['1x', '2x', '3x', '4x', '5x', '6x', '7x', '8x', '9x', '10x', '11x', '12x'];
const selectedInstallment = ref('1x');
</script>

<template>
  <div class="min-h-screen bg-gray-50 pt-3">
    <header class="bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <router-link to="/"
          class="flex items-center space-x-2 p-2 px-3 text-gray-600 bg-white border rounded-2xl hover:bg-gray-100 transition-colors duration-150"
          style="border-color: #E6E9EE;">
          <ArrowLeftIcon class="w-5 h-5 ml-1" />

          <span class="font-semibold text-gray-600">Voltar a Produtos</span>
        </router-link>
      </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
      <div class="lg:grid lg:grid-cols-3 lg:gap-8">

        <div class="lg:col-span-2">
          <CartItem v-for="item in cartItems" :key="item.id" :item="item" @update:quantity="updateItemQuantity"
            @remove="removeItem" />

          <div v-if="cartItems.length === 0" class="text-center text-gray-500 p-8 bg-white rounded-2xl shadow-sm">
            O carrinho está vazio
          </div>
        </div>

        <aside class="lg:col-span-1 mt-6 lg:mt-0 sticky top-20">
          <div class="bg-white p-6 rounded-2xl border border-gray-100">
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
              <span class="text-lg font-semibold text-gray-600">Subtotal</span>
              <span class="text-xl font-bold text-gray-900">{{ formattedSubtotal }}</span>
            </div>

            <div class="pt-4">
              <label class="flex items-center space-x-2 p-3 rounded-xl cursor-pointer transition-colors duration-150"
                :class="{ 'bg-blue-50 border border-blue-400': selectedPayment === 'Pix', 'hover:bg-gray-50': selectedPayment !== 'Pix' }">
                <input type="radio" value="Pix" v-model="selectedPayment"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
                <span class="text-lg font-medium text-gray-800">Pix</span>
              </label>

              <label
                class="flex items-center space-x-2 p-3 mt-2 rounded-xl cursor-pointer transition-colors duration-150"
                :class="{ 'bg-blue-50 border border-blue-400': selectedPayment === 'Credit Card', 'hover:bg-gray-50': selectedPayment !== 'Credit Card' }">
                <input type="radio" value="Credit Card" v-model="selectedPayment"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
                <span class="text-lg font-medium text-gray-800">Cartão de Crédito</span>
              </label>
            </div>

            <div v-if="selectedPayment === 'Credit Card'" class="mt-6">
              <h4 class="text-md font-semibold text-gray-800 mb-3">Número de Parcelas</h4>
              <div class="grid grid-cols-4 gap-2">
                <button v-for="inst in installments" :key="inst" @click="selectedInstallment = inst" :class="[
                  'py-2 text-sm font-medium rounded-lg transition-colors duration-150 border',
                  inst === selectedInstallment
                    ? 'bg-gray-900 text-white border-gray-900 shadow'
                    : 'bg-white text-gray-800 border-gray-300 hover:bg-gray-50'
                ]">
                  {{ inst }}
                </button>
              </div>
              <p class="text-xs text-gray-500 mt-2">Opções de parcelamento a partir de 2 parcelas incluem juros. O valor
                final é
                atualizado de acordo com a sua escolha.</p>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
              <div class="flex justify-between items-center mb-4">
                <span class="text-xl font-bold text-gray-800">Total</span>
                <span class="text-2xl font-bold text-gray-900">{{ formattedSubtotal }}</span>
              </div>

              <button
                class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl flex items-center justify-center hover:bg-blue-700 transition-colors duration-150">
                <LockClosedIcon class="w-5 h-5 mr-2" /> Checkout Seguro
              </button>
            </div>
          </div>
        </aside>
      </div>
    </main>
  </div>
</template>