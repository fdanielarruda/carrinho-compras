<script setup lang="ts">
import { defineEmits, ref, onMounted } from 'vue';
import { useProductStore } from '@/stores/productStore';

const productStore = useProductStore();

const emit = defineEmits<{
  (e: 'filter-selected', filterValues: string[]): void
  (e: 'close'): void
}>();

const availableCategories = productStore.availableCategories;

const selectedFilters = ref<string[]>(productStore.selectedCategoryFilters);

const applyFilters = () => {
  emit('filter-selected', selectedFilters.value);
};

const clearFilters = () => {
  selectedFilters.value = [];
};

onMounted(() => {
  selectedFilters.value = [...productStore.selectedCategoryFilters];
});
</script>

<template>
  <div
    class="absolute right-0 top-10 w-96 bg-white rounded-lg shadow-xl py-2 z-50 origin-top-right ring-1 ring-black ring-opacity-5"
    @mouseleave="$emit('close')">

    <p class="px-4 py-2 text-sm font-semibold text-gray-700 border-b">Filtrar por categorias</p>

    <div class="p-2 max-h-60 overflow-y-auto grid grid-cols-2 gap-x-2">
      <label v-for="category in availableCategories" :key="category"
        class="flex items-center cursor-pointer px-2 py-1.5 rounded-md hover:bg-gray-100 transition-colors duration-100">

        <input type="checkbox" :value="category" v-model="selectedFilters"
          class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />

        <span class="ml-3 text-sm font-medium text-gray-700 whitespace-nowrap overflow-hidden text-ellipsis">
          {{ category }}
        </span>
      </label>

      <p v-if="availableCategories?.length === 0" class="px-2 py-1.5 text-xs text-gray-500 col-span-2">
        Nenhuma categoria encontrada.
      </p>

    </div>

    <div class="border-t mt-2 pt-2 flex flex-col space-y-2 px-4">

      <button @click="applyFilters"
        :disabled="selectedFilters.length === 0 && productStore.selectedCategoryFilters.length === 0"
        class="w-full px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 disabled:bg-indigo-300 transition-colors duration-150">
        Aplicar Filtros ({{ selectedFilters.length }})
      </button>

      <button @click="clearFilters"
        class="w-full py-2 text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-100">
        Limpar filtros
      </button>

    </div>
  </div>
</template>