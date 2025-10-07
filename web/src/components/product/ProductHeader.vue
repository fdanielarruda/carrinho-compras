<script setup lang="ts">
import { ref, watch } from 'vue';
import { ShoppingCartIcon, MagnifyingGlassIcon, AdjustmentsHorizontalIcon } from '@heroicons/vue/24/outline';
import { useProductStore } from '@/stores/productStore';
import { useCartStore } from '@/stores/cartStore';
import CategoryFilterDropdown from './CategoryFilterDropdown.vue';

const productStore = useProductStore();
const cartStore = useCartStore();

const localSearchTerm = ref(productStore.searchTerm);
let searchTimeout: number | undefined = undefined;

const showCategoryFilter = ref(false);

const toggleCategoryFilter = () => {
  showCategoryFilter.value = !showCategoryFilter.value;
};

const handleFilterSelection = (filterValues: string[]) => {
  productStore.setCategoryFilters(filterValues);
  showCategoryFilter.value = false;
};

watch(localSearchTerm, (newTerm) => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    productStore.setSearchTerm(newTerm);
  }, 300);
});
</script>

<template>
  <header class="bg-gray-50 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">

      <div class="flex-grow pr-3 lg:pr-8">
        <div class="relative">
          <input type="text" placeholder="Pesquisar..." v-model="localSearchTerm"
            class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-2xl focus:outline-none transition-shadow duration-150"
            style="border-color: #E6E9EE;" />

          <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
        </div>
      </div>

      <div class="relative flex items-center space-x-4">
        <button @click="toggleCategoryFilter"
          class="flex items-center space-x-2 p-2.5 text-gray-900 bg-white border rounded-2xl hover:bg-gray-100 transition-colors duration-150"
          :class="{ 'ring-2 ring-indigo-500': showCategoryFilter }" style="border-color: #E6E9EE;">
          <AdjustmentsHorizontalIcon class="w-5 h-5" />
        </button>

        <span v-if="productStore.selectedCategoryFilters.length > 0"
          class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-black rounded-full">
          {{ productStore.selectedCategoryFilters.length }}
        </span>

        <CategoryFilterDropdown v-if="showCategoryFilter" @filter-selected="handleFilterSelection"
          @close="showCategoryFilter = false" />
      </div>
      <div class="flex items-center space-x-4 ml-3">
        <router-link to="/carrinho"
          class="relative flex items-center space-x-2 p-2.5 text-gray-900 bg-white border rounded-2xl hover:bg-gray-100 transition-colors duration-150"
          style="border-color: #E6E9EE;">
          <ShoppingCartIcon class="w-5 h-5" />

          <span v-if="cartStore.totalItemsCount > 0"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-black rounded-full">
            {{ cartStore.totalItemsCount }}
          </span>
        </router-link>
      </div>
    </div>
  </header>
</template>