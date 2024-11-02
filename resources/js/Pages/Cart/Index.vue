<script setup lang="ts">
import type {Address, Order} from "@/Types/types";
import ClientLayout from "@/Layouts/ClientLayout.vue";
import {CheckIcon, ClockIcon, QuestionMarkCircleIcon, XMarkIcon, PlusIcon} from '@heroicons/vue/20/solid'
import {router, useForm} from "@inertiajs/vue3";
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import AddressModalComponent from "@/Components/Client/Address/AddressModalComponent.vue";
import {toast, type ToastOptions} from "vue3-toastify";

const props = defineProps({
    order_prop: {
        type: Object as () => Order,
        required: true
    },
    cart_count: {
        type: Number,
        required: true
    },
    addresses: {
        type: Array as () => Address[],
        required: true
    },
    stripe_key: {
        type: String,
        required: true
    }
})
const order = ref<Order>(props.order_prop);
const stripe = ref(null);

onMounted(() => {
   if (!window.Stripe) {
                const stripeJs = document.createElement('script');
                stripeJs.src = 'https://js.stripe.com/v3/';
                stripeJs.onload = () => {
                    stripe.value = Stripe(props.stripe_key); // Use environment variable for key
                };
                document.head.appendChild(stripeJs);
            } else {
                stripe.value = Stripe(props.stripe_key);
            }
})
const showAddressModal = ref(false);

const closeAddressModal = () => {
    showAddressModal.value = false;
};

const updateQuantity = (orderItemId: number, quantity: number) => {
    axios.post(route('order.update_order_item', orderItemId), {quantity: quantity})
        .then(response => {
            order.value = response.data.order
            toast.success("The quantity of the item has been updated successfully", {
                autoClose: 1000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastOptions);
        })
        .catch(error => {
            console.log(error)
        })
}
const updateOrderAddress = (orderId: number, addressId: number) => {
    axios.put(route('order.update', orderId), {address_id: addressId})
        .then(response => {
            order.value = response.data.order
            toast.success("The Address has been updated successfully", {
                autoClose: 2000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastOptions);
        })
        .catch(error => {
            console.log(error)
        })
}
const orderTotalCost = computed(() => {
    return order.value.order_items.reduce((acc, orderItem) => {
        return acc + orderItem.price * orderItem.quantity
    }, 0)
})

const checkoutOrder = async () => {
   await axios.get(route('order.complete_checkout', order.value.id))
        .then(async response => {
            // router.visit('/')
            toast.success("The order has been added successfully", {
                autoClose: 2000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastOptions);
            // Redirect to Stripe Checkout
            await stripe.value.redirectToCheckout({sessionId: response.data.stripe_session_id});
        }).catch(error => {
            toast.error("An error occurred when checking out and making the payment via stripe", {
                autoClose: 3000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastOptions);
        })
}
const removeItemFromCart = (orderItemId: number) => {
    axios.delete(route('order.remove_item', orderItemId))
        .then(response => {
            order.value = response.data.order
            toast.warning("Order Item removed from the Cart", {
                autoClose: 2000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastOptions);
        })
        .catch(error => {
            console.log(error)
        })
}
</script>

<template>
    <ClientLayout :cart_count="cart_count">

        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Shopping Cart</h1>
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
                                                       class="font-medium text-gray-700 hover:text-gray-800">{{
                                                            orderItem.product.name
                                                        }}</a>
                                                </h3>
                                            </div>
                                            <div class="mt-1 flex flex-col text-sm">
                                                <p class="text-gray-500">{{ orderItem.product.description }}</p>
                                                <p class="text-gray-500">{{ orderItem.product?.category.name }}</p>
                                            </div>
                                            <p class="mt-1 text-sm font-medium text-gray-900">${{ orderItem.price }}</p>
                                        </div>

                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <label :for="`quantity-${orderItemsIdx}`" class="sr-only">Quantity,
                                                {{ orderItem.product.name }}</label>
                                            <select :id="`quantity-${orderItemsIdx}`"
                                                    :name="`quantity-${orderItemsIdx}`"
                                                    v-model="orderItem.quantity"
                                                    @change="updateQuantity(orderItem.id, $event.target.value)"
                                                    class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                                <option :value="quantity" v-for="quantity in 20">{{ quantity }}</option>
                                            </select>
                                            <div class="absolute right-0 top-0">
                                                <button type="button"
                                                        @click="removeItemFromCart(orderItem.id)"
                                                        class="-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <XMarkIcon class="h-5 w-5" aria-hidden="true"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="mt-4 flex space-x-2 text-sm text-gray-700">
                                        <!--                  <CheckIcon v-if="product.inStock" class="h-5 w-5 flex-shrink-0 text-green-500" aria-hidden="true" />-->
                                        <!--                  <ClockIcon v-else class="h-5 w-5 flex-shrink-0 text-gray-300" aria-hidden="true" />-->
                                        <!--                  <span>{{ product.inStock ? 'In stock' : `Ships in ${product.leadTime}` }}</span>-->
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Order summary -->
                    <section aria-labelledby="summary-heading"
                             class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">${{ orderTotalCost }}</dd>
                            </div>
                            <!--            <div class="flex items-center justify-between border-t border-gray-200 pt-4">-->
                            <!--              <dt class="flex items-center text-sm text-gray-600">-->
                            <!--                <span>Shipping estimate</span>-->
                            <!--                <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">-->
                            <!--                  <span class="sr-only">Learn more about how shipping is calculated</span>-->
                            <!--                  <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />-->
                            <!--                </a>-->
                            <!--              </dt>-->
                            <!--              <dd class="text-sm font-medium text-gray-900">$5.00</dd>-->
                            <!--            </div>-->
                            <!--            <div class="flex items-center justify-between border-t border-gray-200 pt-4">-->
                            <!--              <dt class="flex text-sm text-gray-600">-->
                            <!--                <span>Tax estimate</span>-->
                            <!--                <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">-->
                            <!--                  <span class="sr-only">Learn more about how tax is calculated</span>-->
                            <!--                  <QuestionMarkCircleIcon class="h-5 w-5" aria-hidden="true" />-->
                            <!--                </a>-->
                            <!--              </dt>-->
                            <!--              <dd class="text-sm font-medium text-gray-900">$8.32</dd>-->
                            <!--            </div>-->
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Order total</dt>
                                <dd class="text-base font-medium text-gray-900">${{ orderTotalCost }}</dd>
                            </div>
                        </dl>
                        <br>
                        <h2 id="address-heading" class="text-lg font-medium text-gray-900">Address information</h2>
                        <div class="flex flex-col mt-4 space-y-3">
                            <div class="flex flex-row justify-between">
                                <label>Shipping Addresses</label>
                                <button type="button" @click="showAddressModal = true"
                                        class="rounded-md bg-success text-white flex flex-row items-center p-2">
                                    <PlusIcon class="h-5 w-5" aria-hidden="true"/>
                                    Add Address
                                </button>
                            </div>
                            <select id="addresses_select"
                                    name="addresses_select"
                                    v-model="order.address_id"
                                    @change="updateOrderAddress(order.id, $event.target.value)"
                                    class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                <option :value="address.id" v-for="address in addresses">{{ address.address_line1 }},
                                    {{ address.postal_code }}, {{ address.city }}, {{ address.state }},
                                    {{ address.country }}
                                </option>
                            </select>
                        </div>
                        <div class="mt-6">
                            <button type="button" @click="checkoutOrder"
                                    class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                Checkout
                            </button>
                        </div>
                    </section>
                </div>
                <AddressModalComponent :show="showAddressModal" @close="closeAddressModal"/>
            </div>
        </div>
    </ClientLayout>
</template>

<style scoped>

</style>
