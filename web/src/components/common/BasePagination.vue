<script setup lang="ts">
import { defineProps, defineEmits, computed } from 'vue';

const props = defineProps<{
  currentPage: number;
  lastPage: number;
}>();

const emit = defineEmits(['page-change']);

const PAGE_RANGE = 2;

const setPage = (page: number) => {
  if (page >= 1 && page <= props.lastPage && page !== props.currentPage) {
    emit('page-change', page);
  }
};

const pages = computed(() => {
  const pageArray = [];

  const start = Math.max(1, props.currentPage - PAGE_RANGE);
  const end = Math.min(props.lastPage, props.currentPage + PAGE_RANGE);

  for (let i = start; i <= end; i++) {
    pageArray.push(i);
  }

  return pageArray;
});

const isFirstPage = computed(() => props.currentPage === 1);
const isLastPage = computed(() => props.currentPage === props.lastPage);
</script>

<template>
  <div v-if="props.lastPage > 1" class="flex justify-center items-center mt-10">
    <nav class="flex space-x-2" aria-label="Pagination">

      <button @click="setPage(props.currentPage - 1)" :disabled="isFirstPage" :class="[
        'h-10 px-4 flex items-center justify-center rounded-xl text-sm transition-colors duration-200',
        isFirstPage
          ? 'text-gray-400 bg-white border border-gray-200 cursor-not-allowed'
          : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
      ]">
        Anterior
      </button>

      <button v-for="page in pages" :key="page" @click="setPage(page)" :class="[
        'w-10 h-10 flex items-center justify-center rounded-xl text-lg font-semibold transition-colors duration-200',
        page === props.currentPage
          ? 'bg-gray-900 text-white shadow-lg'
          : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
      ]" :aria-current="page === props.currentPage ? 'page' : undefined">
        {{ page }}
      </button>

      <button @click="setPage(props.currentPage + 1)" :disabled="isLastPage" :class="[
        'h-10 px-4 flex items-center justify-center rounded-xl text-sm transition-colors duration-200',
        isLastPage
          ? 'text-gray-400 bg-white border border-gray-200 cursor-not-allowed'
          : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
      ]">
        Próxima
      </button>
    </nav>
  </div>
</template>