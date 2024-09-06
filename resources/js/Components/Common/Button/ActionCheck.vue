<script setup>
import {Link} from "@inertiajs/vue3";

defineEmits(['click'])
defineProps({
  link: Boolean,
  to: String
})
</script>

<template>
  <Link v-if="link" :href="to" class="hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full">
    <i class="bi bi-check-circle-fill
 text-yellow-500"></i>
  </Link>
  <button v-else @click="$emit('click')"
          class="hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full" >
    <i class="bi bi-check-circle-fill
 text-yellow-500"></i>
  </button>
</template>

<style scoped>

</style>
