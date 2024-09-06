<script setup>
const props = defineProps({
    status: String,
})

const getColor = (status) => {
    const colors = {
        low: 'info',
        medium: 'warning',
        high: 'error',
    }
    return colors[status.toLowerCase().replace(/\s+/g, '_')]
}

</script>

<template>
    <VChip size="small" :color="getColor(status)" variant="tonal">{{status.toUpperCase()}}</VChip>
</template>

<style scoped>

</style>
