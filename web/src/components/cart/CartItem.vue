<script setup lang="ts">
import { formatCurrencyBRL } from '@/utils/formatters';
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/outline';

interface Product {
  id: number;
  name: string;
  price: number;
  image: string;
  quantity: number;
}

const props = defineProps<{
  item: Product;
}>();

const emit = defineEmits(['update:quantity', 'remove']);

const updateQuantity = (newQuantity: number) => {
  if (newQuantity >= 1) {
    emit('update:quantity', props.item.id, newQuantity);
  }
};
</script>

<template>
  <div class="flex flex-col p-3 sm:p-4 bg-white rounded-xl sm:rounded-2xl border border-gray-100 mb-4">
    
    <div class="flex">
      <div class="flex-shrink-0 w-20 h-20 sm:w-24 sm:h-24 rounded-lg sm:rounded-xl overflow-hidden mr-3 sm:mr-4">
        <img :src="item.image" :alt="item.name" class="w-full h-full object-cover" />
      </div>

      <div class="flex-grow flex flex-col justify-center">
        <h3 class="text-base text-gray-800 line-clamp-2">{{ item.name }}</h3>

        <p class="text-base sm:text-xl font-semibold text-gray-900">R$ {{ formatCurrencyBRL(item.price) }}</p>
      </div>
    </div>
    
    <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100">
      
      <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-fit">
        <button @click="updateQuantity(item.quantity - 1)"
          class="p-1.5 h-7 w-7 sm:h-8 sm:w-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors duration-150 flex-shrink-0"
          aria-label="Diminuir quantidade">
          <MinusIcon class="h-4 w-4" />
        </button>

        <input type="text" :value="item.quantity" readonly
          class="w-6 sm:w-8 h-7 sm:h-8 text-center text-gray-900 font-medium text-sm sm:text-base border-l border-r border-gray-300 focus:outline-none flex-shrink-0"
          style="padding: 0; background-color: white;">

        <button @click="updateQuantity(item.quantity + 1)"
          class="p-1.5 h-7 w-7 sm:h-8 sm:w-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors duration-150 flex-shrink-0"
          aria-label="Aumentar quantidade">
          <PlusIcon class="h-4 w-4" />
        </button>
      </div>

      <button @click="$emit('remove', item.id)"
        class="px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors duration-150 flex items-center justify-center flex-shrink-0 w-fit"
        aria-label="Remover item">
        Remover
      </button>
    </div>
    
  </div>
</template>