<script setup lang="ts">
import {computed, onMounted, ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import type {Order} from "@/Types/types";
import axios from "axios";

const emit = defineEmits(['close']);
const orders = ref<Order[]>([]);
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});
const showModal = ref(props.show);

// Watch for changes in the `show` prop to update the modal state
watch(() => props.show, (newVal) => {
    showModal.value = newVal;
    if (showModal.value){
        fetchOrders();
    }
});
// Close the modal and emit the custom `close` event
const closeModal = () => {
    showModal.value = false;
    emit('close');
};
const form = useForm({
    payment_method: '',
    payment_status: '',
    payment_amount: 0,
    payment_date : '',
    order_id: null,
});
const submit = () => {
    form.post(route('admin.payments.store'), {
        onSuccess: () => {
            form.reset()
            closeModal()
        },
    });
};
const paymentMethods = ref(['credit_card', 'paypal', 'mpesa', 'bank_transfer','cash']);
const paymentStatus = ref(['pending', 'completed', 'failed']);

const fetchOrders = () => {
    axios.get(route('admin.payments.json'))
        .then(response => {
            orders.value = response.data.orders;
        })
        .catch(error => {
            console.log(error);
        });
};

</script>

<template>
    <DialogModal
        :show="showModal"
        :max-width="'2xl'"
        :closeable="true"
        @close="closeModal"
    >
        <template #title>
            New Order Payment
        </template>

        <template #content>
            <form @submit.prevent="submit" :disabled="form.processing">

                <div class="mt-4">
                    <InputLabel for="Order" value="Order ID"/>
                    <SelectInput :options="orders.map(order=>({'value':order.id,'label':`Order Id: ${order.id}, Amount: ${order.total_amount}`})) " :required="true"
                                 class="mt-1 block w-full" v-model="form.order_id"/>
                </div>
                <div class="mt-4">
                    <InputLabel for="Payment Method" value="Payment Method"/>
                    <SelectInput :options="paymentMethods.map(pay=>({'value':pay,'label':pay})) " :required="true"
                                 class="mt-1 block w-full" v-model="form.payment_method"/>
                </div>
                <div class="mt-4">
                    <InputLabel for="Payment Method" value="Payment Method"/>
                    <SelectInput :options="paymentStatus.map(pay=>({'value':pay,'label':pay})) " :required="true"
                                 class="mt-1 block w-full" v-model="form.payment_status"/>
                </div>
                <div class="mt-4">
                    <InputLabel for="payment_amount" value="Payment Amount"/>
                    <TextInput
                        id="name"
                        v-model="form.payment_amount"
                        type="number"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="payment_amount"
                    />
                    <InputError class="mt-2" :message="form.errors.payment_amount"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="Payment Date" value="Payment Date"/>
                    <TextInput
                        id="description"
                        v-model="form.payment_date"
                        type="datetime-local"
                        class="mt-1 block w-full"
                        required
                        autocomplete="payment_date"
                    />
                    <InputError class="mt-2" :message="form.errors.payment_date"/>
                </div>


                <div class="flex justify-between mt-4">
                    <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </form>
        </template>
        <template #footer>

        </template>
    </DialogModal>
</template>

<style scoped>

</style>
