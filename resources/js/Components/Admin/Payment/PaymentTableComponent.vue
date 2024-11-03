<script setup lang="ts">
import type {Payment} from "@/Types/types";
import {useDateFormat} from "@vueuse/core";
import {Link} from "@inertiajs/vue3";

defineProps({
    payments: {
        type: Array as () => Payment[],
        required: true
    }
});

const statusVariant = (status: string) => {
    switch (status) {
        case 'pending':
            return 'bg-yellow-200 text-black'
        case 'completed':
            return 'bg-blue-200 text-black'
        case 'failed':
            return 'bg-indigo-200 text-white'
        default:
            return 'bg-gray-200 text-white'
    }
}
const paymentMethodVariant = (status: string) => {
    switch (status) {
        case 'credit_card':
            return 'bg-yellow-200 text-black'
        case 'paypal':
            return 'bg-blue-200 text-black'
        case 'mpesa':
            return 'bg-indigo-200 text-white'
        case 'bank_transfer':
            return 'bg-green-200 text-white'
        case 'cash':
            return 'bg-amber-200 text-white'
        default:
            return 'bg-gray-200 text-white'
    }
}
</script>

<template>
    <div
        class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">All Payments</h4>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                <tr class="bg-gray-2 dark:bg-meta-4">
                    <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Order Link</th>
                    <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Payment Method</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Status</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Amount</th>
                    <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Payment Date</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(payment, key) in payments" :key="key"
                    :class="`${key === payments.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
                    <td class="p-2.5 text-center xl:p-5">
                        <Link :href="route('admin.orders.show',payment.order.id)"
                              class="bg-primary text-white text-xs px-3 py-1 rounded-md">{{ payment.order.id }}
                        </Link>
                    </td>
                    <td class="p-2.5 xl:p-5">
                        <span
                            :class="`px-2 py-1 rounded-full text-xs font-medium ${paymentMethodVariant(payment.payment_method)}`">{{
                                payment.payment_method === 'credit_card' ? 'Stripe' : payment.payment_method
                            }}</span>
                    </td>
                    <td class="p-2.5 xl:p-5">
                        <span
                            :class="`px-2 py-1 rounded-full text-xs font-medium ${statusVariant(payment.payment_status)}`">{{
                                payment.payment_status
                            }}</span>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">{{ payment.payment_amount }}</p>
                    </td>
                    <td class="p-2.5 text-center xl:p-5">
                        <p class="text-black dark:text-white">
                            {{ useDateFormat(payment.payment_date, 'Do MMMM YYYY HH:mm:ss') }}</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>
