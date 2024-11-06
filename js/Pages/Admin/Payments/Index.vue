<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import PaymentTableComponent from "@/Components/Admin/Payment/PaymentTableComponent.vue";
import {ref} from "vue";
import PaymentModalComponent from "@/Components/Admin/Payment/PaymentModalComponent.vue";
import type {Payment} from "@/Types/types";

defineProps({
    payments: {
        type: Array as () => Payment[],
        required: true
    }
});
const showPaymentModal = ref(false);
const closeModal = () => {
  showPaymentModal.value = false;
};
</script>

<template>
    <AdminLayout>
         <div class="space-y-4">
            <div class="flex justify-end">
                <button
                    class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                    @click="showPaymentModal = true">
                    New Payment
                </button>
            </div>
             <PaymentTableComponent :payments="payments"/>
             <PaymentModalComponent :show="showPaymentModal" @close="closeModal"/>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
