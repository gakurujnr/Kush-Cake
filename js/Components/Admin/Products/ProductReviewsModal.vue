<script setup lang="ts">
import type {Product} from "@/Types/types";
import {ref, watch} from "vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useDateFormat} from "@vueuse/core";
import DangerButton from "@/Components/DangerButton.vue";
import axios from "axios";
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    product: {
        type: [Object as () => Product, null],
        required: true
    },
    show: {
        type: Boolean,
        default: false
    }
})
const showModal = ref(props.show)
const emit = defineEmits(['close'])
watch(() => props.show, (newVal) => {
    showModal.value = newVal;
});
const closeModal = () => {
    emit('close');
    // showModal.value = false;
};
const form = useForm({
    review_id: '',
})
const deleteReview = (review_id: number) => {
    form.transform((data) => ({
        ...data,
        review_id: review_id
    })).delete(route('admin.products.review.delete'), {
        onSuccess: () => {
            emit('close')
        }
    })
}
</script>

<template>
    <DialogModal
        :show="showModal"
        :max-width="'2xl'"
        :closeable="false"
        @close="$emit('close')"
    >
        <template #title>
            Product Reviews
        </template>

        <template #content>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                    <tr class="bg-gray-2 dark:bg-meta-4">
                        <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Rating</th>
                        <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Comments</th>
                        <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(review, key) in product.reviews" :key="key"
                        :class="`${key === product.reviews.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
                        <td class="p-2.5 xl:p-5">
                            <p class="text-black dark:text-white">{{ review.rating }}</p>
                        </td>
                        <td class="p-2.5 text-center xl:p-5">
                            <p class="text-black dark:text-white">{{ review.comment }}</p>
                        </td>
                        <td class="p-2.5 text-center xl:p-5">
                            <DangerButton @click="deleteReview(review.id)">Delete</DangerButton>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </template>
        <template #footer>
            <SecondaryButton @click="closeModal">
                Close
            </SecondaryButton>

        </template>
    </DialogModal>
</template>

<style scoped>

</style>
