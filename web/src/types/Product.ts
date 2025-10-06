export interface Product {
    id: number;
    name: string;
    unit_price: number;
    image: string;
    categories: string[] | null;
}

export interface CartItem extends Product {
    quantity: number;
}

export interface CartState {
    items: CartItem[];
    paymentMethod: number;
    installments: number;
    totalPrice: number | null;
    isLoading: boolean;
}

export interface ProductStoreState {
    allProducts: Product[]; 
    isLoading: boolean; 
    error: string;
    searchTerm: string; 
    currentPage: number;
    availableCategories: string[] | null,
    selectedCategoryFilters: string[]; 
}