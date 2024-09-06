<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-[30rem] flex flex-col justify-center p-8 mt-6  bg-white shadow-lg  overflow-hidden sm:rounded-lg">
      <div class="flex justify-center">
        <Link href="/">
          <img src="/img/logo/dilg_logo.svg" class="w-40 h-40" alt="DILG Logo">
        </Link>
      </div>

      <div
          class="w-full mt-8"
      >
        <slot />
      </div>
    </div>
  </div>
</template>
