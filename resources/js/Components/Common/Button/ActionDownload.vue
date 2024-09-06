<script setup>
import {Link} from "@inertiajs/vue3";

defineEmits(['click'])
defineProps({
  link: Boolean,
  to: String
})
</script>

<template>
  <a v-if="link" :href="to" class="hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full" target="_blank">
    <i class="bi bi-download text-orange-500"></i>
  </a>
  <button v-else @click="$emit('click')"
          class="hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full">
    <i class="bi bi-download text-orange-500"></i>
  </button>
</template>

<style scoped>

</style>
