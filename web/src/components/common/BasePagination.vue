<script setup lang="ts">
import { defineProps, defineEmits, computed } from 'vue';

const props = defineProps<{
  currentPage: number;
  startPage: number;
  endPage: number;
}>();

const emit = defineEmits(['page-changed']);

const setPage = (page: number) => {
  emit('page-changed', page);
  console.log('Carregar página:', page);
};

const pages = computed(() => {
  const pageArray = [];
  for (let i = props.startPage; i <= props.endPage; i++) {
    pageArray.push(i);
  }
  return pageArray;
});
</script>

<template>
  <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-10">
    <nav class="flex space-x-2" aria-label="Pagination">
      <button v-for="page in pages" :key="page" @click="setPage(page)" :class="[
        'w-10 h-10 flex items-center justify-center rounded-xl text-lg font-semibold transition-colors duration-200',
        page === props.currentPage
          ? 'bg-gray-900 text-white shadow-lg'
          : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'
      ]" :aria-current="page === props.currentPage ? 'page' : undefined">
        {{ page }}
      </button>
    </nav>
  </div>
</template>