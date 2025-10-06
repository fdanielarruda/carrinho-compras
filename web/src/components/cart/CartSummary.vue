<script setup lang="ts">
import { ref } from 'vue';
import { LockClosedIcon } from '@heroicons/vue/24/outline';
import PaymentSelector from './PaymentSelector.vue';

defineProps<{
  formattedSubtotal: string;
}>();

const selectedPayment = ref('Pix'); 
</script>

<template>
  <aside class="lg:col-span-1 mt-6 lg:mt-0 sticky top-20">
    <div class="bg-white p-6 rounded-2xl border border-gray-100">
      <div class="flex justify-between items-center pb-4 border-b border-gray-200">
        <span class="text-md font-semibold text-gray-600">Subtotal</span>
        <span class="text-lg font-bold text-gray-900">{{ formattedSubtotal }}</span>
      </div>

      <PaymentSelector v-model="selectedPayment" />

      <div class="mt-6 pt-4 border-t border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <span class="text-xl font-bold text-gray-800">Total</span>
          <span class="text-2xl font-bold text-gray-900">{{ formattedSubtotal }}</span>
        </div>

        <button
          class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl flex items-center justify-center hover:bg-blue-700 transition-colors duration-150">
          <LockClosedIcon class="w-5 h-5 mr-2" /> Checkout Seguro
        </button>
      </div>
    </div>
  </aside>
</template>