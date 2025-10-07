<script setup lang="ts">
import { ref, watch } from 'vue';

const installments = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

const props = withDefaults(defineProps<{
  selectedPayment: string | null;
  selectedInstallment: number | null;
}>(), {
  selectedPayment: null,
  selectedInstallment: null,
});

const emit = defineEmits(['update:selectedPayment', 'update:selectedInstallment']);

const internalPayment = ref<string | null>(props.selectedPayment);
const internalInstallment = ref<number | null>(props.selectedInstallment);

watch(() => props.selectedPayment, (newValue) => {
  internalPayment.value = newValue;
});

watch(() => props.selectedInstallment, (newValue) => {
  internalInstallment.value = newValue;
});

watch(internalPayment, (newValue) => {
  emit('update:selectedPayment', newValue);

  if (newValue === 'Pix') {
    internalInstallment.value = 1;
    emit('update:selectedInstallment', 1);
  } else if (newValue === 'Credit Card') {
    internalInstallment.value = 1;
    emit('update:selectedInstallment', 1);
  } else if (newValue === null) {
    internalInstallment.value = null;
    emit('update:selectedInstallment', null);
  }
});

const setInstallment = (inst: number) => {
  internalInstallment.value = inst;
  emit('update:selectedInstallment', inst);
};
</script>

<template>
  <div class="pt-4">
    <div>
      <label class="flex items-center space-x-2 p-3 rounded-xl cursor-pointer transition-colors duration-150 border"
        :class="{ 'bg-blue-50 border-blue-400': internalPayment === 'Pix', 'border-gray-200 hover:bg-gray-50': internalPayment !== 'Pix' }">
        <input type="radio" value="Pix" v-model="internalPayment"
          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
        <span class="text-lg font-medium text-gray-800">Pix</span>
      </label>

      <label
        class="flex items-center space-x-2 p-3 mt-2 rounded-xl cursor-pointer transition-colors duration-150 border"
        :class="{ 'bg-blue-50 border-blue-400': internalPayment === 'Credit Card', 'border-gray-200 hover:bg-gray-50': internalPayment !== 'Credit Card' }">
        <input type="radio" value="Credit Card" v-model="internalPayment"
          class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" />
        <span class="text-lg font-medium text-gray-800">Cartão de Crédito</span>
      </label>
    </div>

    <div v-if="internalPayment === 'Credit Card'" class="mt-6">
      <h4 class="text-md font-semibold text-gray-800 mb-3">Número de Parcelas</h4>
      <div class="grid grid-cols-4 gap-2">
        <button v-for="inst in installments" :key="inst" @click="setInstallment(inst)"
          class="py-2 text-sm font-medium rounded-lg transition-colors duration-150 border" :class="[
            inst === internalInstallment
              ? 'bg-gray-900 text-white border-gray-900 shadow'
              : 'bg-white text-gray-800 border-gray-300 hover:bg-gray-50'
          ]">
          {{ inst }}x
        </button>
      </div>

      <p class="text-xs text-gray-500 mt-2">Opções de parcelamento a partir de 2 parcelas incluem juros. O valor final é
        atualizado de acordo com a sua escolha.</p>
    </div>
  </div>
</template>