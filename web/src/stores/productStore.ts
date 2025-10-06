import { defineStore } from 'pinia';
import axios from 'axios';
import type { Product } from '@/types/Product';

const PRODUCTS_PER_PAGE = 12;

export const useProductStore = defineStore('product', {
  state: () => ({
    allProducts: [] as Product[],
    isLoading: false,
    error: '',
    searchTerm: '',
    currentPage: 1,
  }),

  getters: {
    filteredProducts: (state) => {
      const products = state.allProducts || [];

      if (!state.searchTerm) {
        return products;
      }

      const searchLower = state.searchTerm.toLowerCase();

      return products.filter(product =>
        product.name.toLowerCase().includes(searchLower)
      );
    },

    lastPage(): number {
      return Math.ceil(this.filteredProducts.length / PRODUCTS_PER_PAGE);
    },

    products(): Product[] {
      const start = (this.currentPage - 1) * PRODUCTS_PER_PAGE;
      const end = start + PRODUCTS_PER_PAGE;

      return this.filteredProducts.slice(start, end);
    }
  },

  actions: {
    async fetchProducts() {
      this.isLoading = true;
      this.error = '';

      try {
        const API_BASE_URL = 'http://localhost:8000/api';
        const response = await axios.get(`${API_BASE_URL}/products`);

        this.allProducts = response.data.products;
        this.currentPage = 1;
      } catch (err) {
        this.error = 'Falha ao carregar todos os produtos.';
        console.error(err);
      } finally {
        this.isLoading = false;
      }
    },

    setSearchTerm(term: string) {
      this.searchTerm = term;
      this.currentPage = 1;
    },

    async goToPage(page: number) {
      if (page >= 1 && page <= this.lastPage && page !== this.currentPage) {
        this.currentPage = page;
      }
    }
  },
});