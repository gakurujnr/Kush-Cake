<script setup lang="ts">

import type {Address} from "@/Types/types";
import {ref, watch} from "vue";
import DialogModal from "@/Components/DialogModal.vue";

const props = defineProps({
    addresses: {
        type: Array as () => Address[],
        required: true
    },
    show: {
        type: Boolean,
        default: false
    }
})
const showModal = ref(props.show);
const emit = defineEmits(['close']);

watch(() => props.show, (newVal) => {
    showModal.value = newVal;
});

const closeModal = () => {
    showModal.value = false;
    emit('close');
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
            User Addresses
        </template>

        <template #content>
          <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
              <thead>
                <tr class="bg-gray-2 dark:bg-meta-4">
                  <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Address Line 1</th>
                  <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Address Line 2</th>
                  <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">City</th>
                  <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">State</th>
                  <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Country</th>
                  <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Postal Code</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(address, key) in addresses" :key="key" :class="`${key === addresses.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
                  <td class="p-2.5 xl:p-5">
                    <p class="text-black dark:text-white">{{ address.address_line_1 }}</p>
                  </td>
                  <td class="p-2.5 text-center xl:p-5">
                    <p class="text-black dark:text-white">{{ address.address_line_2 }}</p>
                  </td>
                  <td class="p-2.5 text-center xl:p-5">
                    <p class="text-black dark:text-white">{{ address.city }}</p>
                  </td>
                  <td class="p-2.5 text-center xl:p-5">
                    <p class="text-black dark:text-white">{{ address.state }}</p>
                  </td>
                  <td class="p-2.5 text-center xl:p-5">
                    <p class="text-black dark:text-white">{{ address.country }}</p>
                  </td>
                  <td class="p-2.5 text-center xl:p-5">
                    <p class="text-black dark:text-white">{{ address.postal_code }}</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>


        </template>
        <template #footer>


        </template>
    </DialogModal>
</template>

<style scoped>

</style>
