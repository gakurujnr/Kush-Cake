<script setup lang="ts">

import DialogModal from "@/Components/DialogModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {Link, useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import type {Product} from "@/Types/types";
import SelectInput from "@/Components/SelectInput.vue";

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    products: {
        type: Array as () => Product[],
        required: true,
    },
});
const showModal = ref(props.show);

// Watch for changes in the `show` prop to update the modal state
watch(() => props.show, (newVal) => {
    showModal.value = newVal;
});
// Close the modal and emit the custom `close` event
const closeModal = () => {
    showModal.value = false;
    emit('close');
};
const form = useForm({
    name: '',
    description: '',
    product_id: null,

});
const submit = () => {
    form.post(route('admin.customization.store'), {
        onSuccess: () => {
            form.reset()
            closeModal()
        },
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
            New Product Customization
        </template>

        <template #content>
            <form @submit.prevent="submit" :disabled="form.processing">
                <div>
                    <InputLabel for="name" value="Name"/>
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="Description" value="Description"/>
                    <TextInput
                        id="description"
                        v-model="form.description"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autocomplete="description"
                    />
                    <InputError class="mt-2" :message="form.errors.description"/>
                </div>
                <div class="mt-4">
                    <InputLabel for="Product" value="Product"/>
                    <SelectInput :options="products.map(prod=>({'value':prod.id,'label':prod.name})) " :required="true"
                                 class="mt-1 block w-full" v-model="form.product_id"/>
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
