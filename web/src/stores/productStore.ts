import { defineStore } from 'pinia';
import type { Product, ProductStoreState } from '@/types/Product';
import api from '@/services/api';

const PRODUCTS_PER_PAGE = 12;

export const useProductStore = defineStore('product', {
  state: (): ProductStoreState => ({
    allProducts: [] as Product[],
    isLoading: false,
    error: '',
    searchTerm: '',
    currentPage: 1,
    availableCategories: [] as string[] | null,
    selectedCategoryFilters: [] as string[],
  }),

  getters: {
    filteredProducts: (state) => {
      const products = state.allProducts || [];

      const searchLower = state.searchTerm.toLowerCase();
      let filteredBySearch = products;
      if (state.searchTerm) {
        filteredBySearch = products.filter(product =>
          product.name.toLowerCase().includes(searchLower)
        );
      }

      if (state.selectedCategoryFilters.length === 0) {
        return filteredBySearch;
      }

      const selectedLower = state.selectedCategoryFilters.map(cat => cat.toLowerCase());

      return filteredBySearch.filter(product =>
        product.categories?.some(category =>
          selectedLower.includes(category.toLowerCase())
        )
      );
    },

    lastPage(): number {
      return Math.ceil(this.filteredProducts.length / PRODUCTS_PER_PAGE);
    },

    products(): Product[] {
      const start = (this.currentPage - 1) * PRODUCTS_PER_PAGE;
      const end = start + PRODUCTS_PER_PAGE;

      return this.filteredProducts.slice(start, end);
    },

    filterDescription(state: ProductStoreState): string {
      const parts = [];

      if (state.searchTerm) {
        parts.push(`"${state.searchTerm}"`);
      }

      if (state.selectedCategoryFilters.length > 0) {
        const categories = state.selectedCategoryFilters.join(', ');
        parts.push(`em: ${categories}`);
      }

      if (parts.length === 0) {
        return 'Exibindo todos os produtos.';
      }

      const prefix = state.searchTerm && state.selectedCategoryFilters.length > 0
        ? 'Pesquisa por'
        : state.searchTerm
          ? 'Busca por'
          : 'Filtro';

      return `${prefix} ${parts.join(' ')}`;
    },
  },

  actions: {
    async fetchProducts() {
      this.isLoading = true;
      this.error = '';

      try {
        const response = await api.get('/products');

        this.allProducts = response.data.products;
        this.currentPage = 1;

        this.extractUniqueCategories();

      } catch (err) {
        this.error = 'Falha ao carregar os produtos.';
        console.error(err);
      } finally {
        this.isLoading = false;
      }
    },

    extractUniqueCategories() {
      const allCategories = this.allProducts.flatMap(product => product.categories);
      const stringCategories = allCategories.filter((category): category is string => category !== null);

      const uniqueCategories = Array.from(new Set(stringCategories));
      this.availableCategories = uniqueCategories.sort((a, b) => a.localeCompare(b));
    },

    setSearchTerm(term: string) {
      this.searchTerm = term;
      this.currentPage = 1;
    },

    setCategoryFilters(filters: string[]) {
      this.selectedCategoryFilters = filters;
      this.currentPage = 1;
    },

    async goToPage(page: number) {
      if (page >= 1 && page <= this.lastPage && page !== this.currentPage) {
        this.currentPage = page;
      }
    }
  },
});