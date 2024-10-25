<script setup lang="ts">


import {ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import DialogModal from "@/Components/DialogModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import type {OrderItem} from "@/Types/types";
import { toast, type ToastOptions } from 'vue3-toastify';

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    order_item: {
        type: [Object as () => OrderItem,null],
        required: true
    }
});
const showModal = ref(props.show);

// Watch for changes in the `show` prop to update the modal state
watch(() => props.show, (newVal) => {
  showModal.value = newVal;
});
watch(() => props.order_item, (newVal) => {
  form.order_item_id = newVal?.id;
});
// Close the modal and emit the custom `close` event
const closeModal = () => {
  showModal.value = false;
  emit('close');
};
const form = useForm({
    order_item_id: props.order_item?.id,
    rating: 10,
    comment: '',

});
const submit = () => {
    form.post(route('order.rating'), {
        onSuccess: () => {
            form.reset()
            closeModal()
            toast.success("Review Added Successfully", {
                autoClose: 2000,
                position: toast.POSITION.BOTTOM_RIGHT,
            } as ToastOptions);
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
            Product Rating
            </template>

            <template #content>
               <form @submit.prevent="submit" :disabled="form.processing">
            <div>
                <InputLabel for="comment" value="Comment" />
                <TextInput
                    id="name"
                    v-model="form.comment"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.comment" />
            </div>

            <div class="mt-4">
                <InputLabel for="Rating" value="Rating" />
                 <SelectInput :options="[1,2,3,4,5,6,7,8,9,10].map(rat=>({'value':rat,'label':rat})) " :required="true"
                                 class="mt-1 block w-full" v-model="form.rating"/>
                <InputError class="mt-2" :message="form.errors.rating" />
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
