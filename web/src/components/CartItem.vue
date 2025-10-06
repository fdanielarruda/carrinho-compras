<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import { MinusIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';

interface Product {
  id: number;
  name: string;
  price: string;
  image: string;
  alt: string;
  quantity: number;
  inStock: boolean;
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
  <div class="flex items-center p-4 bg-white rounded-2xl border border-gray-100 mb-4">
    <div class="flex-shrink-0 w-24 h-24 rounded-xl overflow-hidden mr-4">
      <img :src="item.image" :alt="item.alt" class="w-full h-full object-cover" />
    </div>

    <div class="flex-grow flex flex-col sm:flex-row sm:justify-between sm:items-center">
      <div class="flex flex-col justify-center mb-2 sm:mb-0">
        <h3 class="text-lg font-semibold text-gray-800">{{ item.name }}</h3>
        
        <p class="text-lg font-semibold text-gray-900 mt-1 sm:hidden">{{ item.price }}</p>

        <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden mt-2 w-fit">
          <button @click="updateQuantity(item.quantity - 1)"
            class="p-2 h-8 w-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors duration-150 flex-shrink-0">
            <MinusIcon class="h-4 w-4" />
          </button>

          <input type="text" :value="item.quantity" readonly
            class="w-8 h-8 text-center text-gray-900 font-medium border-l border-r border-gray-300 focus:outline-none flex-shrink-0"
            style="padding: 0; background-color: white;">

          <button @click="updateQuantity(item.quantity + 1)"
            class="p-2 h-8 w-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors duration-150 flex-shrink-0">
            <PlusIcon class="h-4 w-4" />
          </button>
        </div>
      </div>

      <div class="flex items-center space-x-6 mt-2 sm:mt-0">
        <p class="text-xl font-semibold text-gray-900 hidden sm:block">{{ item.price }}</p>

        <button @click="$emit('remove', item.id)"
          class="p-2 text-sm font-medium text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors duration-150 w-10 h-10 flex items-center justify-center flex-shrink-0">
          <TrashIcon class="h-6 w-6" />
        </button>
      </div>
    </div>
  </div>
</template>