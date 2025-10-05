<template>
  <v-container>
    <h2 class="text-h4 mb-6">Featured Products</h2>

    <v-row>
      <v-col v-for="product in products" :key="product.id" cols="12" sm="6" md="3" lg="3">
        <ProductCard :product="product" @add-to-cart="handleAddToCart" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue';
import ProductCard from '@/components/ProductCard.vue';

const products = ref([
  { id: 1, name: 'Ergo Lounge Chair', price: 129.00, image: 'teste.png' },
]);

const handleAddToCart = (product) => {
  console.log(`Produto ${product.name} adicionado ao carrinho!`);
};
</script>