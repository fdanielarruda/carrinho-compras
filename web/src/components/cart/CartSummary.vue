<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import PaymentSelector from './PaymentSelector.vue';
import { formatCurrencyBRL } from '@/utils/formatters';

defineProps<{
  subtotal: number;
  totalPrice: number | null;
  isLoading: boolean;
}>();

const emit = defineEmits(['update:payment']);

const selectedPayment = ref('Pix');
const selectedInstallment = ref(1);

computed(() => {
  return selectedPayment.value === 'Pix' ? 1 : 2;
});

const isDiscountActive = computed(() => {
  return selectedPayment.value === 'Pix' || (selectedPayment.value === 'Credit Card' && selectedInstallment.value === 1);
});

watch([selectedPayment, selectedInstallment], ([newPayment, newInstallment]) => {
  const methodId = newPayment === 'Pix' ? 1 : 2;
  const installmentValue = newPayment === 'Pix' ? 1 : newInstallment;

  emit('update:payment', methodId, installmentValue);
}, { immediate: true });

</script>

<template>
  <aside class="lg:col-span-1 mt-6 lg:mt-0 sticky top-20">
    <div class="bg-white p-6 rounded-2xl border border-gray-100">
      <div class="flex justify-between items-center pb-4 border-b border-gray-200">
        <span class="text-md font-semibold text-gray-600">Subtotal</span>
        <span class="text-lg font-bold text-gray-900">{{ formatCurrencyBRL(subtotal) }}</span>
      </div>

      <PaymentSelector v-model:selected-payment="selectedPayment" v-model:selected-installment="selectedInstallment" />

      <div class="mt-6 pt-4 border-t border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <div class="flex items-center">
            <span class="text-xl font-bold text-gray-800">Total</span>

            <span v-if="isDiscountActive"
              class="ml-2 px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-lg">
              10% OFF
            </span>
          </div>

          <div class="flex flex-col items-end">
            <span v-if="isDiscountActive" class="text-sm text-gray-400 line-through">
              {{ formatCurrencyBRL(subtotal) }}
            </span>

            <span class="text-2xl font-bold text-gray-900">
              <span v-if="isLoading">...</span>
              <span v-else>{{ formatCurrencyBRL(totalPrice) }}</span>
            </span>
          </div>
        </div>

      </div>
    </div>
  </aside>
</template>