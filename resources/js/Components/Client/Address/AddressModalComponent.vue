<script setup lang="ts">

import {ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";

const emit = defineEmits(['close']);

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
});
// Close the modal and emit the custom `close` event
const closeModal = () => {
    showModal.value = false;
    emit('close');
};
const form = useForm({
    'address_line1':'',
    'address_line2':'',
    'city':'',
    'state':'',
    'country':'',
    'postal_code':'',
});
const submit = () => {
    form.post(route('address.store'), {
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
                New Address
            </template>

            <template #content>
               <form @submit.prevent="submit" :disabled="form.processing">
            <div>
                <InputLabel for="address_line1" value="Address Line 1" />
                <TextInput
                    id="address_line1"
                    v-model="form.address_line1"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="address"
                />
                <InputError class="mt-2" :message="form.errors.address_line1" />
            </div>
                   <div>
                <InputLabel for="address_line2" value="Address Line 2" />
                <TextInput
                    id="address_line2"
                    v-model="form.address_line2"
                    type="text"
                    class="mt-1 block w-full"
                    autofocus
                    autocomplete="address"
                />
                <InputError class="mt-2" :message="form.errors.address_line2" />
            </div>

            <div class="mt-4">
                <InputLabel for="city" value="City" />
                <TextInput
                    id="city"
                    v-model="form.city"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="city"
                />
                <InputError class="mt-2" :message="form.errors.city" />
            </div>

            <div class="mt-4">
                <InputLabel for="state" value="State" />
                <TextInput
                    id="state"
                    v-model="form.state"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="state"
                />
                <InputError class="mt-2" :message="form.errors.state" />
            </div>

            <div class="mt-4">
                <InputLabel for="country" value="Country" />
                <TextInput
                    id="country"
                    v-model="form.country"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="country"
                />
                <InputError class="mt-2" :message="form.errors.country" />
            </div>

            <div class="mt-4">
                <InputLabel for="postal_code" value="Postal Code" />
                <TextInput
                    id="postal_code"
                    v-model="form.postal_code"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="Address"
                />
                <InputError class="mt-2" :message="form.errors.postal_code" />
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
