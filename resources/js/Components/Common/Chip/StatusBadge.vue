<script setup>
const props = defineProps({
    status: String,
})

const getColor = (status) => {
    const colors = {
        pending: 'warning',
        on_process: 'info',
        declined: 'error',
        complete: 'success',
        incomplete: 'gray',
        open: 'warning'
    }
    return colors[status.toLowerCase().replace(/\s+/g, '_')]
}

</script>

<template>
    <VChip size="small" :color="getColor(status)" variant="tonal">{{status.toUpperCase()}}</VChip>
</template>

<style scoped>

</style>
