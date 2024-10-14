<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import UsersTableComponent from "@/Components/Admin/Users/UsersTableComponent.vue";
import type {User} from "@/Types/types";


defineProps({
    users: {
        type: Array as () => User[],
        required: true
    }
})
</script>

<template>
    <AdminLayout>
        <div>
         <UsersTableComponent :users="users"/>
        </div>
    </AdminLayout>

</template>

<style scoped>

</style>
