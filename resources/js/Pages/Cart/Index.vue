<script setup lang="ts">
import type {Order} from "@/Types/types";

defineProps({
    order: {
        type: Object as () => Order,
        required: true
    }
})
</script>

<template>
    <a href="">{{order}}</a>
</template>

<style scoped>

</style>
