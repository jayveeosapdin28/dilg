<script setup>
defineProps({
  link:String,
  title: String
})
</script>

<template>
  <div class=" mb-4">
    <small class="text-slate-500">{{link}}</small>
    <h1 class="text-xl font-semibold ">{{title}}</h1>
  </div>
</template>

<style scoped>

</style>
