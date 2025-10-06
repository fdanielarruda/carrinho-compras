<script setup lang="ts">
import { defineProps } from 'vue';
import { PlusIcon } from '@heroicons/vue/24/outline';

defineProps({
  product: {
    type: Object,
    required: true,
    default: () => ({
      name: 'Nome do Produto',
      price: 'R$ 0.00',
      image: 'https://via.placeholder.com/300x200?text=Produto',
      alt: 'Descrição da Imagem'
    })
  }
});
</script>

<template>
  <div class="bg-white rounded-2xl border transition-shadow duration-300 overflow-hidden">

    <div class="h-32 overflow-hidden">
      <img :src="product.image" :alt="product.alt"
        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" />
    </div>

    <div class="p-3">
      <h3 class="text-md font-semibold text-gray-800 mb-1 truncate">{{ product.name }}</h3>

      <div class="flex justify-between items-center mt-3">
        <p class="text-lg font-semibold text-gray-900">{{ product.price }}</p>

        <button
          class="flex items-center text-gray-800 p-2 rounded-xl hover:bg-gray-200 transition-colors duration-200 border"
          style="background-color: #F1F5F9;">

          <PlusIcon class="h-5 w-5 text-dark-500" />
        </button>
      </div>
    </div>
  </div>
</template>