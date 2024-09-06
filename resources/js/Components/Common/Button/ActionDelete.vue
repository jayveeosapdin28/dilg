<script setup>
defineEmits(['click'])
</script>

<template>
<button @click="$emit('click')" class="hover:bg-primary-200 flex justify-center items-center h-6 w-6 rounded-full">
    <i class="bi bi-trash text-red-500"></i>
</button>
</template>

<style scoped>

</style>
