<script setup lang="ts">
import type {Order} from "@/Types/types";
import ClientLayout from "@/Layouts/ClientLayout.vue";

defineProps({
    order: {
        type: Object as () => Order,
        required: true
    }
})
</script>

<template>
    <ClientLayout>

    <a href="">{{order}}</a>
    </ClientLayout>
</template>

<style scoped>

</style>
