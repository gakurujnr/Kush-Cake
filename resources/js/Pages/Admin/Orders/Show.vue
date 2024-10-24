<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import type {Order} from "@/Types/types";
import AddressModalComponent from "@/Components/Client/Address/AddressModalComponent.vue";
import {PlusIcon, XMarkIcon} from "@heroicons/vue/20/solid";
import {computed} from "vue";
const props = defineProps({
    order:{
        type: Object as () => Order,
        required: true
    }
})
const orderTotalCost = computed(() => {
    return props.order.order_items.reduce((acc, orderItem) => {
        return acc + orderItem.price * orderItem.quantity
    }, 0)
})
</script>

<template>
<AdminLayout>
            <div class="bg-white dark:bg-gray-800">
            <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">Shopping Cart</h1>
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
                                                <p class="text-gray-500 dark:text-gray-300">{{ orderItem.product.description }}</p>
                                                <p class="text-gray-500 dark:text-gray-300">{{ orderItem.product?.category.name }}</p>
                                            </div>
                                            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">${{ orderItem.price }}</p>
                                        </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ orderItem.quantity }}</dd>

                                        </div>
                                    </div>


                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading"
                             class="mt-16 rounded-lg px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8 bg-gray-50  dark:bg-gray-700">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900 dark:text-white">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">${{ orderTotalCost }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900 dark:text-gray-100">Order total</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-gray-100">${{ orderTotalCost }}</dd>
                            </div>
                        </dl>
                        <br>
                        <h2 id="address-heading" class="text-lg font-medium text-gray-900 dark:text-white">Address information</h2>
                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Address Line 1</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ order?.address?.address_line1 }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Address Line 2</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ order?.address?.address_line2 }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">City</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ order?.address?.city }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">State</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ order?.address?.state }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Country</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ order?.address?.country }}</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600 dark:text-gray-400">Postal Code</dt>
                                <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ order?.address?.postal_code }}</dd>
                            </div>

                        </dl>

                    </section>
                </div>
            </div>
        </div>

</AdminLayout>
</template>

<style scoped>

</style>
