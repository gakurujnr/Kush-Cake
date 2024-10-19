<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import PaymentTableComponent from "@/Components/Admin/Payment/PaymentTableComponent.vue";

</script>

<template>

    <AdminLayout>
         <div class="space-y-4">
            <div class="flex justify-end">
                <button
                    class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                >
                    New Payment
                </button>
            </div>
             <PaymentTableComponent/>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
