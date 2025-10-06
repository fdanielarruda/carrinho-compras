<script setup lang="ts">
import { ref } from 'vue';

const currentPage = ref(1);
const totalPages = 3;

const setPage = (page) => {
  currentPage.value = page;
  console.log('Carregar página:', page);
};
</script>

<template>
  <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-10">

    <nav class="flex space-x-2" aria-label="Pagination">
      <button v-for="page in totalPages" :key="page" @click="setPage(page)" :class="[
        'w-10 h-10 flex items-center justify-center rounded-xl text-lg font-semibold transition-colors duration-200',
        page === currentPage
          ? 'bg-gray-900 text-white shadow-lg'
          : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
      ]" aria-current="page">
        {{ page }}
      </button>
    </nav>
  </div>
</template>