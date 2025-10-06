import { defineStore } from 'pinia';
import type { Product, CartState } from '@/types/Product';

export const useCartStore = defineStore('cart', {
  state: (): CartState => ({
    items: [],
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
    }
  },
});