<script setup lang="ts">
import { onMounted } from 'vue';
import { useProductStore } from '@/stores/productStore.ts';
import ProductHeader from '@/components/product/ProductHeader.vue';
import ProductCard from '@/components/product/ProductCard.vue';
import BasePagination from '@/components/common/BasePagination.vue';

const productStore = useProductStore();

onMounted(() => {
  productStore.fetchProducts();
});

const handlePageChange = (page: number) => {
  productStore.goToPage(page);
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 pt-3">
    <ProductHeader />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

      <div v-if="productStore.isLoading" class="text-center py-10 text-gray-600">
        Carregando produtos...
      </div>

      <div v-else-if="productStore.error" class="text-center py-10 text-red-600 font-bold bg-red-100 rounded-lg">
        {{ productStore.error }}
      </div>

      <div v-else-if="productStore.products.length === 0" class="text-center py-10 text-gray-500">
        Nenhum produto encontrado.
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <ProductCard v-for="product in productStore.products" :key="product.id" :product="product" />
      </div>

      <BasePagination :currentPage="productStore.currentPage" :lastPage="productStore.lastPage"
        @page-change="handlePageChange" />
    </main>
  </div>
</template>