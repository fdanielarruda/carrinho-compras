<script setup lang="ts">
import { ref, watch } from 'vue';

const installments = ['1x', '2x', '3x', '4x', '5x', '6x', '7x', '8x', '9x', '10x', '11x', '12x'];

const props = defineProps<{
  modelValue: string;
}>();

const emit = defineEmits(['update:modelValue']);

const selectedPayment = ref(props.modelValue);
const selectedInstallment = ref('1x');

watch(selectedPayment, (newValue) => {
  emit('update:modelValue', newValue);
  
  if (newValue !== 'Credit Card') {
    selectedInstallment.value = '1x';
  }
});
</script>

<template>
  <div class="pt-4">
    <div>
      <label class="flex items-center space-x-2 p-3 rounded-xl cursor-pointer transition-colors duration-150"
        :class="{ 'bg-blue-50 border border-blue-400': selectedPayment === 'Pix', 'hover:bg-gray-50': selectedPayment !== 'Pix' }">
        <input type="radio" value="Pix" v-model="selectedPayment"
          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
        <span class="text-lg font-medium text-gray-800">Pix</span>
      </label>

      <label class="flex items-center space-x-2 p-3 mt-2 rounded-xl cursor-pointer transition-colors duration-150"
        :class="{ 'bg-blue-50 border border-blue-400': selectedPayment === 'Credit Card', 'hover:bg-gray-50': selectedPayment !== 'Credit Card' }">
        <input type="radio" value="Credit Card" v-model="selectedPayment"
          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
        <span class="text-lg font-medium text-gray-800">Cartão de Crédito</span>
      </label>
    </div>

    <div v-if="selectedPayment === 'Credit Card'" class="mt-6">
      <h4 class="text-md font-semibold text-gray-800 mb-3">Número de Parcelas</h4>
      <div class="grid grid-cols-4 gap-2">
        <button v-for="inst in installments" :key="inst" @click="selectedInstallment = inst" :class="[
          'py-2 text-sm font-medium rounded-lg transition-colors duration-150 border',
          inst === selectedInstallment
            ? 'bg-gray-900 text-white border-gray-900 shadow'
            : 'bg-white text-gray-800 border-gray-300 hover:bg-gray-50'
        ]">
          {{ inst }}
        </button>
      </div>
      <p class="text-xs text-gray-500 mt-2">
        Opções de parcelamento a partir de 2 parcelas incluem juros. O valor final é atualizado de acordo com a sua
        escolha.</p>
    </div>
  </div>
</template>