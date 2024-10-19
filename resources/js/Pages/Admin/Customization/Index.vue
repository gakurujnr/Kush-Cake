<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import CustomizationModal from "@/Components/Admin/Customization/CustomizationModal.vue";
import {ref} from "vue";
import type {Customization, Product} from "@/Types/types";
import CustomizationTableComponent from "@/Components/Admin/Customization/CustomizationTableComponent.vue";
const props = defineProps({
    products : {
        type: Array as () => Product[]
    },
    customizations : {
        type: Array as () => Customization[]
    }
})
const showCustomizationModal = ref(false);
const closeModal = () => {
  showCustomizationModal.value = false;
};
</script>

<template>
<AdminLayout>
    <div class="space-y-4">
     <div class="flex justify-end">
                <button
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                @click="showCustomizationModal = true"
              >
                New Product Customization
              </button>
     </div>
         <CustomizationTableComponent :customizations="customizations"/>
         <CustomizationModal :show="showCustomizationModal" @close="closeModal" :products="products"/>
     </div>
</AdminLayout>
</template>

<style scoped>

</style>
