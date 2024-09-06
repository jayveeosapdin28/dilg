<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {useAttrs} from "vue";
const attrs = useAttrs();
defineProps({
  link:Boolean,
  to: String
})
</script>

<template>
  <SecondaryButton :link="link" :to="to" v-bind="attrs">
    <i class="bi bi-chevron-left mr-1"></i>
    Back
  </SecondaryButton>
</template>

<style scoped>

</style>
