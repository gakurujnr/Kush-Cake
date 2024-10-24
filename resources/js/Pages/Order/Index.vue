<script setup lang="ts">

import ClientLayout from "@/Layouts/ClientLayout.vue";
import type {Order} from "@/Types/types";
import {useDateFormat} from "@vueuse/core";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    cart_count: {
        type: Number,
        required: true
    },
    orders: {
        type: Array as () => Order[],
        required: true
    }
});
const statusVariant = (status: string) => {
    switch (status) {
        case 'pending':
            return 'bg-yellow-200 text-black'
        case 'processing':
            return 'bg-blue-200 text-black'
        case 'shipped':
            return 'bg-indigo-200 text-white'
        case 'delivered':
            return 'bg-green-200 text-white'
        case 'cancelled':
            return 'bg-red-200 text-white'
        default:
            return 'bg-gray-200 text-white'
    }
}
</script>

<template>
 <ClientLayout :cart_count="cart_count">
    <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
            <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">All Orders</h4>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                <tr class="bg-gray-2 dark:bg-meta-4">
                    <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Order Id</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">User</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Status</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Total Amount</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Address</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Creation Date</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(order, key) in orders" :key="key"
                    :class="`${key === orders.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`"
              >
                    <td class="py-4 text-sm">
                        <p class="text-black dark:text-white text-sm">{{ order.id }}</p>
                    </td>
                    <td class="text-sm">
                        <p class="text-black dark:text-white">{{ order.user.name }}, {{ order.user.email }}</p>
                    </td>
                    <td class=" text-center">
                        <span :class="`px-2 py-1 rounded-full text-xs font-medium ${statusVariant(order.status)}`">{{
                                order.status
                            }}</span>

                    </td>
                    <td class="text-center text-sm">
                        <p class="text-black dark:text-white">{{ order.total_amount }}</p>
                    </td>
                    <td class=" text-center text-sm">
                        <p class="text-black dark:text-white">{{ order?.address?.address_line1 }}</p>
                    </td>
                    <td class="text-center text-sm">
                        <p class="text-black dark:text-white">
                            {{ useDateFormat(order.created_at, 'Do MMMM YYYY HH:mm:ss') }}</p>
                    </td>
                    <td class="text-center text-sm">
                        <Link :href="route('order.show',order.id)"
                              class="bg-primary text-white text-xs px-3 py-1 rounded-md">View Details
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>

 </ClientLayout>
</template>

<style scoped>

</style>
