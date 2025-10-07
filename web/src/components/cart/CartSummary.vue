<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import PaymentSelector from './PaymentSelector.vue';
import { formatCurrencyBRL } from '@/utils/formatters';
import { LockClosedIcon } from '@heroicons/vue/24/outline';

const props = defineProps<{
  subtotal: number;
  totalPrice: number | null;
  isLoading: boolean;
}>();

const emit = defineEmits(['update:payment']);

const selectedPayment = ref<string | null>(null);
const selectedInstallment = ref<number | null>(null);

const isDiscountActive = computed(() => {
  return props.subtotal > 0 && ((selectedPayment.value === 'Pix') || (selectedPayment.value === 'Credit Card' && selectedInstallment.value === 1));
});

watch([selectedPayment, selectedInstallment], ([newPayment, newInstallment]) => {
  const methodId = newPayment === 'Pix' ? 1 : 2;
  const installmentValue = newPayment === 'Pix' ? 1 : newInstallment;

  emit('update:payment', methodId, installmentValue);
}, { immediate: true });

const isPaymentSelected = computed(() => {
  return selectedPayment.value !== null && selectedInstallment.value !== null;
});

</script>

<template>
  <aside class="lg:col-span-1 mt-6 lg:mt-0 sticky top-20">
    <div class="bg-white p-6 rounded-2xl border border-gray-100">
      <div class="flex justify-between items-center pb-4 border-b border-gray-200">
        <span class="text-md font-semibold text-gray-600">Subtotal</span>
        <span class="text-lg font-bold text-gray-900">R$ {{ formatCurrencyBRL(subtotal) }}</span>
      </div>

      <PaymentSelector v-model:selected-payment="selectedPayment" v-model:selected-installment="selectedInstallment" />

      <div class="mt-6 pt-4 border-t border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <div class="flex items-center">
            <span class="text-xl font-bold text-gray-800">Total</span>
          </div>

          <div class="flex flex-col items-end">
            <div v-if="isDiscountActive" class="flex items-center mb-1">
              <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-lg">
                10% OFF
              </span>

              <span class="ml-2 text-sm text-gray-400 line-through">
                R$ {{ formatCurrencyBRL(subtotal) }}
              </span>
            </div>

            <span class="text-2xl font-bold text-gray-900">
              <span v-if="isLoading">...</span>
              <span v-else>
                <span v-if="totalPrice !== null">
                  R$ {{ formatCurrencyBRL(totalPrice) }}
                </span>
                <span v-else>
                  R$ {{ formatCurrencyBRL(subtotal) }}
                </span>
              </span>
            </span>
          </div>
        </div>

        <button
          class="w-full py-3 bg-blue-600 text-white font-bold rounded-xl flex items-center justify-center hover:bg-blue-700 transition-colors duration-150"
          :disabled="isLoading || totalPrice === null || !isPaymentSelected">
          <LockClosedIcon class="w-5 h-5 mr-2" />
          {{ isLoading ? 'Calculando...' : 'Checkout Seguro' }}
        </button>
      </div>
    </div>
  </aside>
</template>