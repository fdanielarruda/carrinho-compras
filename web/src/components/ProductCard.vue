<template>
    <v-card class="product-card">
        <v-img :src="product.image" height="200px" cover></v-img>

        <v-card-text>
            <div class="text-h6 mb-2">{{ product.name }}</div>
        </v-card-text>

        <v-card-actions class="d-flex justify-space-between align-center">
            <span class="font-weight-bold">{{ formatPrice(product.price) }}</span>
            <v-btn color="primary" variant="tonal" @click="$emit('addToCart', product)">
                Add to Cart
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

const emits = defineEmits(['addToCart']);

const formatPrice = (price) => {
    return `$${price.toFixed(2)}`;
};
</script>

<style scoped>
.product-card {
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
</style>