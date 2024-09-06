<script setup>
import {computed, watch} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {useCrud} from "@/Composables/useCrud.js";
import Loading from "@/Components/Global/Loading.vue";
import NavigationDrawer from "@/Components/Common/Drawer/NavigationDrawer.vue";

const props = defineProps({
    modelValue: [Boolean, String],
    storeId: [String, Number],
    data: Object,
})

const emit = defineEmits(['update:modelValue', 'close', 'on-success'])
const users = computed(() => usePage().props.users);

let form = useForm({
    id: null,
    recipient: props.storeId,
    message: null,
})

watch(() => props.data, (val) => {
    form.id = val.id ?? null
    form.name = val.name ?? null
});


const internalValue = computed({
    set: (val) => {
        emit('update:modelValue', val)
    },
    get: () => props.modelValue
});

const {submitForm} = useCrud();
const submit = async () => {
    await submitForm(form, `admin.chat-rooms.${form.id ? 'update' : 'store'}`, null, true, true)
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
            <p class="font-semibold text-lg">{{ `${form.id ? 'Update' : 'Create'} Message` }}</p>
        </template>
        <template #default>
            <VSelect
                label="Recipient"
                item-title="name"
                item-value="id"
                variant="outlined"
                color="primary"
                :items="users"
                v-model="form.recipient"
                :error-messages="form.errors.recipient"
                @update:model-value="form.clearErrors('recipient')"
            />
            <VTextarea
                color="primary"
                label="Message"
                rows="4"
                variant="outlined"
                density="comfortable"
                v-model="form.message"
                :error-messages="form.errors.message"
                @update:model-value="form.clearErrors('message')"
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
                    {{ form.id ? 'Update' : 'Send' }}
                </VBtn>
            </div>
        </template>
    </NavigationDrawer>
</template>

<style scoped>

</style>
