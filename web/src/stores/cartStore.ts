import { defineStore } from 'pinia';
import type { Product, CartState } from '@/types/Product';
import api from '@/services/api';

export const useCartStore = defineStore('cart', {
  persist: true,
  state: (): CartState => ({
    items: [],
    paymentMethod: 1,
    installments: 1,
    totalPrice: null as number | null,
    isLoading: false,
  }),
  getters: {
    totalItemsCount: (state) => {
      return state.items.reduce((total, item) => total + item.quantity, 0);
    },

    isProductInCart: (state) => (productId: number) => {
      return state.items.some(item => item.id === productId);
    }
  },
  actions: {
    addProductToCart(product: Product) {
      const existingItem = this.items.find(item => item.id === product.id);

      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        this.items.push({ ...product, quantity: 1 });
      }

      console.log(`Produto "${product.name}" adicionado ao carrinho. Quantidade atual: ${this.totalItemsCount}`);
    },

    removeProductFromCart(productId: number) {
      const existingItemIndex = this.items.findIndex(item => item.id === productId);

      if (existingItemIndex !== -1) {
        const productName = this.items[existingItemIndex]?.name;

        this.items.splice(existingItemIndex, 1);

        console.log(`Produto "${productName}" (ID: ${productId}) removido completamente do carrinho. Total de itens: ${this.totalItemsCount}`);
      } else {
        console.log(`Erro: Produto com ID ${productId} não encontrado no carrinho para remoção.`);
      }
    },

    clearCart() {
      this.items = [];
      console.log('O carrinho foi completamente esvaziado.');
    },

    setPaymentOptions(paymentMethod: number, installments: number) {
      this.paymentMethod = paymentMethod;
      this.installments = installments;
      this.calculateTotal();
    },

    async calculateTotal() {
      if (this.items.length === 0) {
        this.totalPrice = 0;
        return;
      }
      
      this.isLoading = true;
      try {
        const apiItems = this.items.map(item => ({
          price: item.unit_price,
          quantity: item.quantity,
        }));

        const payload = {
          items: apiItems,
          payment_method: this.paymentMethod,
          installments: this.installments,
        };

        const response = await api.post('/cart-calculate', payload);

        this.totalPrice = response.data.total_value; 
      } catch (error) {
        console.error('Erro ao calcular total do carrinho:', error);
        this.totalPrice = null;
      } finally {
        this.isLoading = false;
      }
    },

    updateItemQuantity(id: number, newQuantity: number) {
        const item = this.items.find(i => i.id === id);
        if (item) {
            item.quantity = newQuantity;
        }
        this.calculateTotal();
    },
  },
});