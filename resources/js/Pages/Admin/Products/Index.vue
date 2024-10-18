<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import ProductModal from "@/Components/Admin/Products/ProductModal.vue";
import {ref} from "vue";
import type {Category,Product} from "@/Types/types";
import ProductsTableComponent from "@/Components/Admin/Products/ProductsTableComponent.vue";

const props = defineProps({
    categories : {
        type: Array as ()=> Category[]
    },
    products : {
        type: Array as ()=> Product[]
    }
})
const showProductModal = ref(false)
const product = ref<Product|null>(null)
const closeModal = ()=>{
    console.log('close clicked')
    showProductModal.value =false
}
const editProduct = (product_id:number)=>{
    //find the product by id and set it to the product ref
    product.value = props.products.find(product=>product.id === product_id)
    console.log(product.value)
    showProductModal.value = true
}
const newProduct = ()=>{
    product.value = null
    showProductModal.value = true
}
</script>

<template>
<AdminLayout>
    <div class="space-y-4">
        <div class="flex justify-end">
                <button
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                @click="newProduct"
              >
                New Product
              </button>
            </div>
            <ProductsTableComponent :products="products" @edit="editProduct"/>
            <ProductModal :show="showProductModal" @close="closeModal" :categories="categories" :product="product"/>
    </div>
</AdminLayout>
</template>

<style scoped>

</style>
