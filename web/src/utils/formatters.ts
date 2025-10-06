export const formatCurrencyBRL = (value: number | string | null | undefined): string => {
  const numberValue = typeof value === 'string' ? parseFloat(value) : (value || 0);

  if (isNaN(numberValue)) {
    return '0,00';
  }

  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(numberValue);
};