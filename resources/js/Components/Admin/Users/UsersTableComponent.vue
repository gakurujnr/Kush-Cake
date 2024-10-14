<script setup lang="ts">
import {ref} from "vue";
import type {User} from "@/Types/types";
import {useDateFormat} from '@vueuse/core'
//get the users as a prop passed from parent
defineProps({
    users: {
        type: Array as () => User[],
        required: true
    }
})

</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1"
  >
    <h4 class="mb-6 text-xl font-semibold text-black dark:text-white">All Users</h4>

    <div class="flex flex-col">
      <div class="grid grid-cols-3 rounded-sm bg-gray-2 dark:bg-meta-4 sm:grid-cols-5">
        <div class="p-2.5 xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Name</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Email</h5>
        </div>
        <div class="p-2.5 text-center xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">User Type</h5>
        </div>
        <div class="hidden p-2.5 text-center sm:block xl:p-5">
          <h5 class="text-sm font-medium uppercase xsm:text-base">Joining Date</h5>
        </div>
      </div>

      <div
        v-for="(user, key) in users"
        :key="key"
        :class="`grid grid-cols-3 sm:grid-cols-5 ${
          key === users.length - 1 ? '' : 'border-b border-stroke dark:border-strokedark'
        }`"
      >
        <div class="flex items-center gap-3 p-2.5 xl:p-5">
          <p class="hidden text-black dark:text-white sm:block">{{ user.name }}</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
          <p class="text-black dark:text-white">{{ user.email }}K</p>
        </div>

        <div class="flex items-center justify-center p-2.5 xl:p-5">
            <p
                class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium"
                :class="{
                  'bg-warning text-warning': user.user_type === 0,
                  'bg-success text-success': user.user_type === 1
                }"
              >
                {{ user.user_type === 0 ? 'Admin' : 'Customer' }}
              </p>
        </div>

        <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
          <p class="text-black dark:text-white">{{ useDateFormat(user.created_at,'Do MMMM YYYY HH:mm:ss') }}</p>
        </div>


      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
