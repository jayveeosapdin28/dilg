<script setup>
import {computed, watch} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {useCrud} from "@/Composables/useCrud.js";
import Loading from "@/Components/Global/Loading.vue";
import NavigationDrawer from "@/Components/Common/Drawer/NavigationDrawer.vue";
import FileUploader from "@/Components/Common/Form/FileUploader.vue";

const props = defineProps({
    modelValue: [Boolean, String],
    storeId: [String, Number],
    data: Object,
})

const emit = defineEmits(['update:modelValue', 'close', 'on-success'])

let form = useForm({
    id: null,
    name: props.storeId,
    category: null,
    description: null,
    file: null,
    user_id: null,
    file_url: null,
    remove_file: null,
})

watch(() => props.data, (val) => {
    form.id = val.id ?? null
    form.name = val.name ?? null
    form.user_id = val.user_id ?? null
    form.category = val.category ?? null
    form.description = val.description ?? null
    form.file = val.file ?? null
    form.file_url = val.file_url ?? null
});


const internalValue = computed({
    set: (val) => {
        emit('update:modelValue', val)
    },
    get: () => props.modelValue
});

const {submitForm} = useCrud();
const submit = async () => {
    await submitForm(form, `admin.documents.${form.id ? 'update' : 'store'}`, null, true, true)
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

const removeFile = () =>{
    form.remove_file = true;
}

watch(() =>internalValue.value,() =>{
    if(!internalValue.value){
        form.reset();
    }

})

const is_owner = computed(()=> form.user_id === usePage().props.auth.user.id && form.id)

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
            <p class="font-semibold text-lg">{{ `${form.id ? 'Update' : 'Create'} Document` }}</p>
        </template>
        <template #default>
            <VTextField
                color="primary"
                label="Name"
                :disabled="!is_owner"
                variant="outlined"
                density="comfortable"
                v-model="form.name"
                :error-messages="form.errors.name"
                @update:model-value="form.clearErrors('name')"
            />
            <VTextField
                color="primary"
                label="Category"
                :disabled="!is_owner"
                variant="outlined"
                density="comfortable"
                v-model="form.category"
                :error-messages="form.errors.category"
                @update:model-value="form.clearErrors('category')"
            />
            <VTextarea
                color="primary"
                label="Description"
                variant="outlined"
                :disabled="!is_owner"
                density="comfortable"
                v-model="form.description"
                :error-messages="form.errors.description"
                @update:model-value="form.clearErrors('description')"
            />

          <div class="mt-4">
              <FileUploader
                  :id="`${form.id}-id`"
                  :key="`${form.id}-key`"
                  ref="image_uploader"
                  v-model="form.file"
                  :disabled="!is_owner"
                  placeholder="Drop or select document file here"
                  :model-files="form.file_url"
                  @remove-file="removeFile"
                  :error-messages="form.errors.file"
                  @update:model-value="form.clearErrors('file')"
              />
          </div>
        </template>
        <template #footer>
            <div class="flex gap-4 justify-end">
                <VBtn color="error" @click="internalValue = false">
                    Close
                </VBtn>
                <VBtn v-if="is_owner" @click="form.reset()">
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
