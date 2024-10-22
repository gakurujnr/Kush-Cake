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
import SelectInput from "@/Components/SelectInput.vue";
import type {Product, Category} from "@/Types/types";

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    categories: {
        type: Array as () => Category[],
        required: true,
    },
    product: {
        type: [Object as () => Product , null],
        default: null,
    },
});
const showModal = ref(props.show);

// Watch for changes in the `show` prop to update the modal state
watch(() => props.show, (newVal) => {
    showModal.value = newVal;
});
// Close the modal and emit the custom `close` event
const closeModal = () => {
    emit('close');
    // showModal.value = false;
};
const form = useForm({
    name: '',
    description: '',
    price: 0,
    stock: 0,
    category_id: null,
    slug: '',
});
watch(() => props.product, (newVal) => {
    if (newVal) {
        form.name = newVal.name
        form.description = newVal.description
        form.price = newVal.price
        form.stock = newVal.stock
        form.category_id = newVal.category_id
        form.slug = newVal.slug
    } else {
        form.reset()
    }
});
const submit = () => {
    //if product is not null then we are updating
    if (props.product) {
        form.put(route('admin.products.update', props.product.id), {
            onSuccess: () => {
                form.reset()
                closeModal()
            },
        });
    }else{
    form.post(route('admin.products.store'), {
        onSuccess: () => {
            form.reset()
            closeModal()
        },
    });
    }
};
</script>

<template>
    <DialogModal
        :show="showModal"
        :max-width="'2xl'"
        :closeable="false"
        @close="closeModal"
    >
        <template #title>
            New Product
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
                    <InputLabel for="Price" value="Price"/>
                    <TextInput
                        id="price"
                        v-model="form.price"
                        type="number"
                        class="mt-1 block w-full"
                        required
                        autocomplete="price"
                    />
                    <InputError class="mt-2" :message="form.errors.price"/>
                </div>
                <div class="mt-4">
                    <InputLabel for="Stock" value="Stock"/>
                    <TextInput
                        id="stock"
                        v-model="form.stock"
                        type="number"
                        class="mt-1 block w-full"
                        required
                        autocomplete="stock"
                    />
                    <InputError class="mt-2" :message="form.errors.stock"/>
                </div>
                <div class="mt-4">
                    <InputLabel for="Category" value="Category"/>
                    <SelectInput :options="categories.map(cat=>({'value':cat.id,'label':cat.name})) " :required="true"
                                 class="mt-1 block w-full" v-model="form.category_id"/>
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
