<script setup lang="ts">

import type {Product} from "@/Types/types";
import {useDateFormat} from "@vueuse/core";
import PrimaryButton from "@/Components/PrimaryButton.vue";
//define edit emit that passes the id of the product to the parent component
const emit =defineEmits(['edit','addImage','viewReviews']);

defineProps({
    products: {
        type: Array as () => Product[],
        required: true
    }
})

</script>

<template>

    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">All Categories</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                <tr class="bg-gray-2 dark:bg-meta-4">
                    <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Name</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Description</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Slug</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Category</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Price</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Stock</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Image</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, key) in products" :key="key"
                    :class="`${key === products.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
                    <td class="p-2.5 xl:p-5">
                        <p class="text-black dark:text-white">{{ product.name }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ product.description }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ product.slug }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ product.category.name }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ product.price }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ product.stock }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <img :src="product.image?.url" alt="product image" class="w-20 h-20" v-if="product.image"/>
                    </td>
                    <td class="p-2.5 text-center xl:p-5 space-x-2 space-y-2">
                        <PrimaryButton class="bg-primary" type="button" @click="emit('edit',product.id)">Edit</PrimaryButton>
                        <PrimaryButton class="bg-primary" type="button" @click="emit('addImage',product.id)">Add Image</PrimaryButton>
                        <PrimaryButton class="bg-primary" type="button" @click="emit('viewReviews',product.id)">Reviews</PrimaryButton>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>
