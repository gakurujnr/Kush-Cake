<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import ProductModal from "@/Components/Admin/Products/ProductModal.vue";
import {ref} from "vue";
import type {Category} from "@/Types/types";

defineProps({
    categories : {
        type: Array as ()=> Category[]
    }
})
const showProductModal = ref(false)
const closeModal = ()=>{
    showProductModal.value =false
}
</script>

<template>
<AdminLayout>
    <div class="space-y-4">
        <div class="flex justify-end">
                <button
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                @click="showProductModal = true"
              >
                New Product
              </button>
            </div>

            <ProductModal :show="showProductModal" @close="closeModal" :categories="categories"/>
    </div>
</AdminLayout>
</template>

<style scoped>

</style>
