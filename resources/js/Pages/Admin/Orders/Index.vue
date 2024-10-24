<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import OrdersTableComponent from "@/Components/Admin/Orders/OrdersTableComponent.vue";
import type {Order} from "@/Types/types";

defineProps({
    orders: {
        type: Array as () => Order[],
        required: true
    }
})
</script>

<template>

    <AdminLayout>
        <div class="space-y-4">
            <div class="flex justify-end">
<!--                <button-->
<!--                    class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"-->
<!--                >-->
<!--                    New Order-->
<!--                </button>-->
            </div>
            <OrdersTableComponent :orders="orders"/>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
