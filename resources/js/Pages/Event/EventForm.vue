<script setup>
import {computed, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import {useCrud} from "@/Composables/useCrud.js";
import Loading from "@/Components/Global/Loading.vue";
import NavigationDrawer from "@/Components/Common/Drawer/NavigationDrawer.vue";

const props = defineProps({
    modelValue: [Boolean, String],
    storeId: [String, Number],
    data: Object,
})

const emit = defineEmits(['update:modelValue', 'close', 'on-success'])

let form = useForm({
    id: null,
    event_name: props.event_name,
    description: props.description,
    date_open: props.date_open,
    date_close: props.date_close,
    status: props.status,
})

watch(() => props.data, (val) => {
    form.id = val.id ?? null
    form.event_name = val.event_name ?? null
    form.description = val.description ?? null
    form.date_open = val.date_open ?? null
    form.date_closed = val.date_closed ?? null
    form.status = val.status ?? null
});

const internalValue = computed({
    set: (val) => {
        emit('update:modelValue', val)
    },
    get: () => props.modelValue
});

const {submitForm} = useCrud();
const submit = async () => {
    await submitForm(form, `admin.events.${form.id ? 'update' : 'store'}`, null, true, true)
        .then((result) => {
            emit('on-success')
            form.reset();
            internalValue.value = false;
        })
}

const onClose = () => {
    form.reset()
    emit('close')
}


watch(() =>internalValue.value,() =>{
    if(!internalValue.value){
        form.reset();
    }

})

</script>

<template>
    <Loading :show="form.processing"/>
    <NavigationDrawer
        class="z-50"
        @close="onClose"
        v-model="internalValue"
        size="400"
    >
        <template #header>
            <p class="font-semibold text-lg">{{ `${form.id ? 'Update' : 'Create'} Event` }}</p>
        </template>
        <template #default>
            <VTextField
                color="primary"
                label="Name"
                variant="outlined"
                density="comfortable"
                v-model="form.event_name"
                :error-messages="form.errors.event_name"
                @update:model-value="form.clearErrors('event_name')"
            />
            <VTextField
                color="primary"
                label="Date From"
                variant="outlined"
                type="date"
                density="comfortable"
                v-model="form.date_open"
                :error-messages="form.errors.date_open"
                @update:model-value="form.clearErrors('date_open')"
            />
            <VTextField
                color="primary"
                label="Date To"
                type="date"
                variant="outlined"
                density="comfortable"
                v-model="form.date_close"
                :error-messages="form.errors.date_close"
                @update:model-value="form.clearErrors('date_close')"
            />
            <VTextarea
                color="primary"
                label="Description"
                variant="outlined"
                density="comfortable"
                v-model="form.description"
                :error-messages="form.errors.description"
                @update:model-value="form.clearErrors('description')"
            />


        </template>
        <template #footer>
            <div class="flex gap-4 justify-end">
                <VBtn color="error" @click="internalValue = false">
                    Close
                </VBtn>
                <VBtn @click="form.reset()">
                    Clear Fields
                </VBtn>
                <VBtn variant="flat" color="primary" @click="submit">
                    {{ form.id ? 'Update' : 'Submit' }}
                </VBtn>
            </div>
        </template>
    </NavigationDrawer>
</template>

<style scoped>

</style>
