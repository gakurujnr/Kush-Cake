<script setup lang="ts">

import AdminLayout from "@/Layouts/AdminLayout.vue";
import UsersTableComponent from "@/Components/Admin/Users/UsersTableComponent.vue";
import type {Address, User} from "@/Types/types";
import {ref} from "vue";
import UserAddressesComponent from "@/Components/Admin/Users/UserAddressesComponent.vue";


const props =defineProps({
    users: {
        type: Array as () => User[],
        required: true
    }
})
const user = ref<User|null>(null)
const addressModal = ref(false)

const openAddressesModal = (user_id:number)=>{
    addressModal.value = true
    user.value = props.users.find(user=>user.id === user_id)
}
const closeAddressesModal = ()=>{
    user.value = null
    addressModal.value = false
}
</script>

<template>
    <AdminLayout>
        <div>
         <UsersTableComponent :users="users" @openAddressesModal="openAddressesModal"/>
            <UserAddressesComponent :addresses="user?.addresses" :show="addressModal" @close="closeAddressesModal"/>
        </div>
    </AdminLayout>

</template>

<style scoped>

</style>
