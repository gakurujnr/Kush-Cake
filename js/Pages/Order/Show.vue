<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import type {Order, OrderItem} from "@/Types/types";
import AddressModalComponent from "@/Components/Client/Address/AddressModalComponent.vue";
import {PlusIcon, StarIcon} from "@heroicons/vue/20/solid";
import {computed, ref} from "vue";
import {useDateFormat} from "@vueuse/core";
import {Link} from "@inertiajs/vue3";
import ClientLayout from "@/Layouts/ClientLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AddReviewModalComponent from "@/Components/Client/Review/AddReviewModalComponent.vue";

const props = defineProps({
    order: {
        type: Object as () => Order,
        required: true
    },
     cart_count: {
        type: Number,
        required: true
    },
})
const orderTotalCost = computed(() => {
    return props.order.order_items.reduce((acc, orderItem) => {
        return acc + orderItem.price * orderItem.quantity
    }, 0)
})

const selectedOrderItem = ref<OrderItem>(null);
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
const showReviewModal = ref(false);
const closeModal = () => {
    showReviewModal.value = false;
    selectedOrderItem.value = null;
};
const openReviewModal = (orderItem: OrderItem) => {
    selectedOrderItem.value = orderItem;
    showReviewModal.value = true;
};
</script>

<template>
    <ClientLayout :cart_count="cart_count">
        <div class="bg-white dark:bg-gray-800">
            <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">Shopping
                    Cart</h1>
                <div class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                        <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                            <li v-for="(orderItem, orderItemsIdx) in order.order_items" :key="orderItem.id"
                                class="flex py-6 sm:py-10">
                                <div class="flex-shrink-0">
                                    <img :src="orderItem.product.image.url" :alt="orderItem.product.name"
                                         class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48"/>
                                </div>

                                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                        <div>
                                            <div class="flex justify-between">
                                                <h3 class="text-sm">
                                                    <a :href="orderItem.product.id"
                                                       class="font-medium text-gray-700 dark:text-gray-100 hover:text-gray-800">{{
                                                            orderItem.product.name
                                                        }}</a>
                                                </h3>
                                            </div>
                                            <div class="mt-1 flex flex-col text-sm">
                                                <p class="text-gray-500 dark:text-gray-300">
                                                    {{ orderItem.product.description }}</p>
                                                <p class="text-gray-500 dark:text-gray-300">
                                                    {{ orderItem.product?.category.name }}</p>
                                            </div>
                                            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                                ${{ orderItem.price }}</p>
                                            <div class="mt-4 flex items-center" v-if="orderItem.review">
                                                <StarIcon v-for="rating in [ 0,1, 2, 3, 4, 5,6,7,8,9]" :key="rating"
                                                          :class="[orderItem.review.rating > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']"
                                                          aria-hidden="true"/>
                                            </div>
                                            <div class="prose prose-sm mt-4 max-w-none text-gray-500"
                                                 v-if="orderItem.review" v-html="orderItem.review.comment"/>
                                        </div>


                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ orderItem.quantity }}
                                            </dd>
                                            <div class="absolute right-0 top-0" v-if="!orderItem.review && (order.status ==='delivered' || order.status === 'cancelled')">
                                                <button type="button" @click="openReviewModal(orderItem)"
                                                        class="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                                    <PlusIcon class="-mr-0.5 h-5 w-5" aria-hidden="true"/>
                                                    Add Review
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </section>
                    <div class=" lg:col-span-5 space-y-4">
                        <!-- User summary -->
                        <section aria-labelledby="summary-heading"
                                 class="mt-16 rounded-lg px-4 py-6 sm:p-6 lg:mt-0 lg:p-8 bg-gray-50  dark:bg-gray-700">
                            <h2 id="address-heading" class="text-lg font-medium text-gray-900 dark:text-white">User
                                information</h2>
                            <dl class="mt-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Name</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                            order?.user.name
                                        }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Email</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                            order.user.email
                                        }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Joining Date</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ useDateFormat(order.user.created_at, 'Do MMMM YYYY HH:mm:ss') }}
                                    </dd>
                                </div>

                            </dl>

                        </section>
                        <!-- Order summary -->
                        <section aria-labelledby="summary-heading"
                                 class="mt-16 rounded-lg px-4 py-6 sm:p-6 lg:mt-0 lg:p-8 bg-gray-50  dark:bg-gray-700">
                            <h2 id="summary-heading" class="text-lg font-medium text-gray-900 dark:text-white">Order
                                summary</h2>

                            <dl class="mt-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">${{
                                            orderTotalCost
                                        }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                    <dt class="text-base font-medium text-gray-900 dark:text-gray-100">Order total</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        ${{ orderTotalCost }}
                                    </dd>
                                </div>
                            </dl>
                            <br>
                            <h2 id="address-heading" class="text-lg font-medium text-gray-900 dark:text-white">Address
                                information</h2>
                            <dl class="mt-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Address Line 1</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ order?.address?.address_line1 }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Address Line 2</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ order?.address?.address_line2 }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">City</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ order?.address?.city }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">State</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ order?.address?.state }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Country</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ order?.address?.country }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between">
                                    <dt class="text-sm text-gray-600 dark:text-gray-400">Postal Code</dt>
                                    <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ order?.address?.postal_code }}
                                    </dd>
                                </div>

                            </dl>
                        </section>
                    </div>

                </div>

                <div class="bg-gray-100 dark:bg-gray-700 p-4 my-4 rounded-2xl">
                    <h1 class="text-xl my-4 font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-xl">
                        Payments</h1>
                    <div class="overflow-x-auto ">
                        <table class="min-w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 dark:bg-meta-4">
                                <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Payment
                                    Method
                                </th>
                                <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">
                                    Status
                                </th>
                                <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">
                                    Amount
                                </th>
                                <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Payment
                                    Date
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(payment, key) in order.payments" :key="key"
                                :class="`${key === order.payments.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
                                <td class="p-2.5 xl:p-5">
                        <span
                            :class="`px-2 py-1 rounded-full text-xs font-medium ${paymentMethodVariant(payment.payment_method)}`">{{
                                payment.payment_method==='credit_card' ? 'Stripe' : payment.payment_method
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

            </div>

            <AddReviewModalComponent :order_item="selectedOrderItem" :show="showReviewModal" @close="closeModal"/>
        </div>

    </ClientLayout>
</template>

<style scoped>

</style>
