<script setup>
import {Link} from "@inertiajs/vue3";
defineEmits(['click'])
defineProps({
  link:Boolean,
  to: String
})
</script>

<template>
  <Link v-if="link" @click="$emit('click')" :href="to">
    <slot>
      <i class="bi bi-pencil text-sm hover:text-base transition ease-in-out text-primary-300"></i>
    </slot>
  </Link>
  <button v-else @click="$emit('click')">
   <slot>
     <i class="bi bi-pencil text-sm hover:text-base transition ease-in-out text-primary-300"></i>
   </slot>
  </button>
</template>

<style scoped>

</style>
