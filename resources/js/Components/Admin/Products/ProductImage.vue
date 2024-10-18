<script setup lang="ts">

import type {Product} from "@/Types/types";
import {useForm} from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";
import {ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

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
const form = useForm({
    avatar: null,
    product_id: props.product?.id,
})
watch(() => props.show, (newVal) => {
    showModal.value = newVal;
});
const submit = () => {
    form
        .transform((data) => ({
            ...data,
            product_id: props.product.id
        }))
        .post(route('admin.products.images.store'),{
            forceFormData: true,
        preserveScroll: true,
        onSuccess:()=>{
            form.reset()
            emit('close')
        },
        onProgress:(event)=>{
            form.progress = event
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
            New Product
        </template>

        <template #content>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name"/>
                    <input type="file"
                           class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                           @input="form.avatar = $event.target.files[0]"/>
                </div>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                </progress>
                <div class="flex justify-between mt-4">
                    <PrimaryButton class="" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Submit
                    </PrimaryButton>
                    <SecondaryButton @click="emit('close')">
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
