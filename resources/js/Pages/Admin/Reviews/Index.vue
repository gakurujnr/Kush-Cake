<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import ReviewTableComponent from "@/Components/Admin/Reviews/ReviewTableComponent.vue";
</script>

<template>
<AdminLayout>
    <div class="space-y-4">
        <div class="flex justify-end">
<!--            <button-->
<!--                class="flex justify-center rounded bg-primary py-2 px-6 font-medium text-gray hover:bg-opacity-90"-->
<!--            >-->
<!--                New Review-->
<!--            </button>-->
        </div>
        <ReviewTableComponent/>
    </div>
</AdminLayout>
</template>

<style scoped>

</style>
