<script setup lang="ts">
import { computed } from 'vue';
import type { Product } from '@/types/Product';
import { PlusIcon, MinusIcon } from '@heroicons/vue/24/outline';
import { useCartStore } from '@/stores/cartStore';

const cartStore = useCartStore();

const props = defineProps({
  product: {
    type: Object as () => Product,
    required: true
  }
});

const truncateText = (text: string, maxLength: number): string => {
  if (text.length <= maxLength) {
    return text;
  }
  return text.substring(0, maxLength) + '...';
};

const toggleCart = () => {
  if (isInCart.value) {
    cartStore.removeProductFromCart(props.product.id);
  } else {
    cartStore.addProductToCart(props.product);
  }
};

const isInCart = computed(() => {
  return cartStore.isProductInCart(props.product.id);
});

const buttonClasses = computed(() => ({
  'bg-red-500 border-red-500 text-white hover:bg-red-600': isInCart.value,
  'bg-gray-50 border-gray-300 text-gray-700 hover:bg-gray-100': !isInCart.value,
}));

const iconClasses = computed(() => ({
  'text-white': isInCart.value,
  'text-gray-700': !isInCart.value,
}));
</script>

<template>
  <div :title="product.name"
    class="bg-white rounded-2xl border transition-shadow duration-300 hover:shadow-lg overflow-hidden flex flex-col h-full cursor-pointer">

    <div class="h-24 overflow-hidden">
      <img :src="product.image" alt="Imagem do produto"
        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" />
    </div>

    <div class="p-2 px-3 flex-grow flex flex-col justify-between">
      <h3 class="text-sm font-semibold text-gray-800 mb-2">
        {{ truncateText(product.name, 45) }}
      </h3>

      <div class="mt-4 flex justify-between items-center flex-shrink-0">
        <p class="text-lg font-semibold text-gray-900">
          R$ {{ Number(product.unit_price).toFixed(2) }}
        </p>

        <button :title="isInCart ? 'Remover do Carrinho' : 'Adicionar ao Carrinho'" @click.stop="toggleCart"
          class="flex items-center p-2 rounded-xl border transition-colors duration-200" :class="buttonClasses">

          <MinusIcon v-if="isInCart" class="h-5 w-5" :class="iconClasses" />
          <PlusIcon v-else class="h-5 w-5" :class="iconClasses" />
        </button>
      </div>
    </div>
  </div>
</template>