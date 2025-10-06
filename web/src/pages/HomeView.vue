<script setup lang="ts">
import { ref } from 'vue';
import TheHeader from '@/components/TheHeader.vue';
import ProductCard from '@/components/ProductCard.vue';
import ThePagination from '@/components/ThePagination.vue';

const featuredProducts = ref([
  { id: 1, name: 'Ergo Lounge Chair', price: '$129.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Ergo Lounge Chair' },
  { id: 2, name: 'Minimalist Desk Lamp', price: '$59.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Minimalist Desk Lamp' },
  { id: 3, name: 'Wireless Headphones', price: '$89.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Wireless Headphones' },
  { id: 4, name: 'Compact Coffee Maker', price: '$79.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Compact Coffee Maker' },
  { id: 5, name: 'Everyday Sneakers', price: '$99.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Everyday Sneakers' },
  { id: 6, name: 'Fitness Smartwatch', price: '$149.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Fitness Smartwatch' },
  { id: 7, name: 'Urban Travel Backpack', price: '$69.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Urban Travel Backpack' },
  { id: 8, name: 'Insulated Water Bottle', price: '$25.00', image: 'https://cdn.pixabay.com/photo/2017/09/23/04/02/dice-2777809_1280.jpg', alt: 'Insulated Water Bottle' },
]);
</script>

<template>
  <div class="min-h-screen bg-gray-50 pt-3">
    <TheHeader />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <ProductCard v-for="product in featuredProducts" :key="product.id" :product="product" />
      </div>

      <ThePagination />

    </main>
  </div>
</template>