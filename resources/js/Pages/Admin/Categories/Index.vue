<script setup lang="ts">

import type {Category} from "@/Types/types";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CategoriesTableComponent from "@/Components/Admin/Categories/CategoriesTableComponent.vue";
import NewCategoryModal from "@/Components/Admin/Categories/NewCategoryModal.vue";
import {ref} from "vue";

defineProps({
    categories: {
        type: Array as () => Category[],
        required: true
    }
})
const showNewCategoryModal = ref(false);
const closeModal = () => {
  showNewCategoryModal.value = false;
};
</script>

<template>
    <AdminLayout>
        <div class="space-y-4">
            <div class="flex justify-end">
                <button
                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"
                @click="showNewCategoryModal = true"
              >
                New Category
              </button>
            </div>

            <CategoriesTableComponent :categories="categories"/>

            <NewCategoryModal :show="showNewCategoryModal" @close="closeModal"/>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
