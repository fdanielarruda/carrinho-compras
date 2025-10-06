<script setup lang="ts">
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
</script>

<template>
  <header class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
      <router-link to="/"
        class="flex items-center space-x-2 p-2 px-3 text-gray-600 bg-white border rounded-2xl hover:bg-gray-100 transition-colors duration-150"
        style="border-color: #E6E9EE;">
        <ArrowLeftIcon class="w-5 h-5 ml-1" />
        <span class="text-sm font-semibold text-gray-600">Voltar a Produtos</span>
      </router-link>
    </div>
  </header>
</template>