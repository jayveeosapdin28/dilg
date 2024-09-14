<script setup>
import {computed, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import {useCrud} from "@/Composables/useCrud.js";
import Loading from "@/Components/Global/Loading.vue";
import NavigationDrawer from "@/Components/Common/Drawer/NavigationDrawer.vue";
import {useRole} from "@/Composables/useRole.js";

const props = defineProps({
    modelValue: [Boolean, String],
    storeId: [String, Number],
    data: Object,
})

const {isInRole} = useRole();

const emit = defineEmits(['update:modelValue', 'close', 'on-success'])

let form = useForm({
    id: null,
    name: props.name,
    description: props.description,
    date_open: props.date_open,
    date_closed: props.date_closed,
    status: props.status,
})

watch(() => props.data, (val) => {
    form.id = val.id ?? null
    form.name = val.name ?? null
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
    await submitForm(form, `admin.cases.${form.id ? 'update' : 'store'}`, null, true, true)
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


watch(() => internalValue.value, () => {
    if (!internalValue.value) {
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
            <p class="font-semibold text-lg">{{ `${form.id ? 'Update' : 'Create'} Case` }}</p>
        </template>
        <template #default>
            <VTextField
                color="primary"
                label="Name"
                variant="outlined"
                density="comfortable"
                v-model="form.name"
                :error-messages="form.errors.name"
                @update:model-value="form.clearErrors('name')"
            />

            <VTextField
                color="primary"
                label="Open"
                variant="outlined"
                type="date"
                density="comfortable"
                v-model="form.date_open"
                :error-messages="form.errors.date_open"
                @update:model-value="form.clearErrors('date_open')"
            />
            <VTextField
                color="primary"
                label="Close"
                type="date"
                variant="outlined"
                density="comfortable"
                v-model="form.date_closed"
                :error-messages="form.errors.date_closed"
                @update:model-value="form.clearErrors('date_closed')"
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
            <VSelect
                v-if="form.id && (isInRole(['Admin','Super Admin']))"
                color="primary"
                label="Status"
                variant="outlined"
                density="comfortable"
                :items="['Open', 'On Process', 'Hold','Closed']"
                v-model="form.status"
                :error-messages="form.errors.status"
                @update:model-value="form.clearErrors('status')"
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
