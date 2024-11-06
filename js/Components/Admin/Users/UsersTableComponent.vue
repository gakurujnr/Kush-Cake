<script setup lang="ts">
import {ref} from "vue";
import type {User} from "@/Types/types";
import {useDateFormat} from '@vueuse/core'
import PrimaryButton from "@/Components/PrimaryButton.vue";
//get the users as a prop passed from parent
defineProps({
    users: {
        type: Array as () => User[],
        required: true
    }
})
const emit = defineEmits(['openAddressesModal']);
</script>

<template>
  <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
  <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">All Users</h4>

  <div class="overflow-x-auto">
    <table class="min-w-full table-auto">
      <thead>
        <tr class="bg-gray-2 dark:bg-meta-4">
          <th class="p-2.5 text-left text-sm font-medium uppercase xsm:text-base xl:p-5">Name</th>
          <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">Email</th>
          <th class="p-2.5 text-center text-sm font-medium uppercase xsm:text-base xl:p-5">User Type</th>
          <th class="hidden p-2.5 text-center sm:table-cell xl:p-5">Joining Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, key) in users" :key="key" :class="`${key === users.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'}`">
          <td class="p-2.5 xl:p-5">
            <p class="text-black dark:text-white">{{ user.name }}</p>
          </td>
          <td class="p-2.5 text-center xl:p-5">
            <p class="text-black dark:text-white">{{ user.email }}</p>
          </td>
          <td class="p-2.5 text-center xl:p-5">
            <span
              class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium"
              :class="{
                'bg-warning text-warning': user.user_type === 0,
                'bg-success text-success': user.user_type === 1
              }"
            >
              {{ user.user_type === 0 ? 'Admin' : 'Customer' }}
            </span>
          </td>
          <td class="hidden p-2.5 text-center sm:table-cell xl:p-5">
              <PrimaryButton class="bg-primary" type="button" @click="emit('openAddressesModal',user.id)">Addresses</PrimaryButton>

<!--            <p class="text-black dark:text-white">{{ useDateFormat(user.created_at, 'Do MMMM YYYY HH:mm:ss') }}</p>-->
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</template>

<style scoped>

</style>
