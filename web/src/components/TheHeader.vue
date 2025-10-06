<script setup lang="ts">
import { ShoppingCartIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline'
</script>

<template>
  <header class="bg-white sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">

      <div class="flex-grow hidden lg:block pr-8">
        <div class="relative">
          <input type="text" placeholder="Pesquisar..."
            class="w-full py-2 pl-10 pr-4 border border-gray-300 rounded-2xl focus:outline-none transition-shadow duration-150"
            style="border-color: #E6E9EE;" />

          <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <router-link to="/cart"
          class="relative flex items-center space-x-2 p-2.5 text-gray-900 bg-white border rounded-2xl hover:bg-gray-100 transition-colors duration-150"
          style="border-color: #E6E9EE;">
          <ShoppingCartIcon class="w-5 h-5" />

          <span
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-black rounded-full">3</span>
        </router-link>
      </div>
    </div>
  </header>
</template>
