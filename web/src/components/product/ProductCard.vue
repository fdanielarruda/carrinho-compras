<script setup lang="ts">
import type { Product } from '@/types/Product';
import { PlusIcon } from '@heroicons/vue/24/outline';

defineProps({
  product: {
    type: Object as () => Product,
    required: true
  }
});
</script>

<template>
  <div class="bg-white rounded-2xl border transition-shadow duration-300 hover:shadow-lg overflow-hidden">

    <div class="h-32 overflow-hidden">
      <img :src="product.image" alt="Imagem do produto"
        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110" />
    </div>

    <div class="p-2 px-3">
      <h3 class="text-sm font-semibold text-gray-800 mb-2 truncate">
        {{ product.name }}
      </h3>

      <div class="flex justify-between items-center mt-4">
        <p class="text-lg font-semibold text-gray-900">
          R$ {{ Number(product.unit_price).toFixed(2) }}
        </p>

        <button title="Adicionar ao Carrinho"
          class="flex items-center text-gray-800 p-2 rounded-xl border border-gray-300 hover:bg-gray-100 transition-colors duration-200"
          style="background-color: #F1F5F9;">

          <PlusIcon class="h-5 w-5 text-gray-700" />
        </button>
      </div>
    </div>
  </div>
</template>