export interface Product {
    id: number;
    name: string;
    unit_price: number;
    image: string;
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