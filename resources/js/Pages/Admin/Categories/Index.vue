<script setup lang="ts">

import type {Category} from "@/Types/types";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CategoriesTableComponent from "@/Components/Admin/Categories/CategoriesTableComponent.vue";

defineProps({
    categories: {
        type: Array as () => Category[],
        required: true
    }
})
</script>

<template>
    <AdminLayout>
        <div>
            <CategoriesTableComponent :categories="categories"/>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
