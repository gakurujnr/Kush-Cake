<script setup lang="ts">
import {Link} from "@inertiajs/vue3";

import ClientLayout from "@/Layouts/ClientLayout.vue";
import type {Order} from "@/Types/types";

defineProps({
    order: Object as ()=> Order
})
</script>

<template>
<ClientLayout>
    <div class="container mx-auto">
        <div class="flex justify-center items-center h-screen">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-green-500">Payment Successful</h1>
                <p class="text-gray-500 mt-2">Thank you for your payment.</p>
                <Link :href="route('order.show',order.id)"
                      class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >Click here to view the order details</Link>
            </div>
        </div>
    </div>
</ClientLayout>
</template>

<style scoped>

</style>
