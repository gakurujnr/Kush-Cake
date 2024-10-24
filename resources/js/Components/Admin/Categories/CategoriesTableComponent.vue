<script setup lang="ts">

import {useDateFormat} from "@vueuse/core";
import {ref} from "vue";

import type {Category} from "@/Types/types";

defineProps({
    categories: {
        type: Array as () => Category[],
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
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(category, key) in categories" :key="key"
                    :class="`${key === categories.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
                    <td class="p-2.5 xl:p-5">
                        <p class="text-black dark:text-white">{{ category.name }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ category.description }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">
                            {{ useDateFormat(category.created_at, 'Do MMMM YYYY HH:mm:ss') }}</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<style scoped>

</style>
