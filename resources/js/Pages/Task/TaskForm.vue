<script setup>
import {computed, watch} from "vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {useCrud} from "@/Composables/useCrud.js";
import Loading from "@/Components/Global/Loading.vue";
import NavigationDrawer from "@/Components/Common/Drawer/NavigationDrawer.vue";
import FileUploader from "@/Components/Common/Form/FileUploader.vue";
import DatePicker from "@/Components/Common/Form/DatePicker.vue";
import {useRole} from "@/Composables/useRole.js";
import Editor from "@/Components/Common/Form/Editor.vue";
import {useFormat} from "@/Composables/useFormat.js";

const props = defineProps({
  modelValue: [Boolean, String],
  storeId: [String, Number],
  data: Object,
})

const emit = defineEmits(['update:modelValue', 'close', 'on-success'])
const users = computed(() => usePage().props.users)
const {date} = useFormat()

let form = useForm({
  id: null,
  name: props.storeId,
  description: null,
  due_date: null,
  priority: null,
  status: null,
  users: null,
  comments: null,
})

watch(() => props.data, (val) => {
  form.id = val.id ?? null
  form.name = val.name ?? null
  form.description = val.description ?? null
  form.due_date = date(val.due_date,'YYYY-MM-DD') ?? null
  form.priority = val.priority ?? null
  form.status = val.status ?? null
  form.users = val.users ?? null
  form.comments = val.comments ?? null
});


const internalValue = computed({
  set: (val) => {
    emit('update:modelValue', val)
  },
  get: () => props.modelValue
});

const {submitForm} = useCrud();
const submit = async () => {
  await submitForm(form, `admin.tasks.${form.id ? 'update' : 'store'}`, null, true, true)
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
      width="900"
  >
    <template #header>
      <p class="font-semibold text-lg">{{ `${form.id ? 'Update' : 'Create'} Task` }}</p>
    </template>
    <template #default>


      <div class="grid md:grid-cols-2 gap-4">
        <VTextField
            color="primary"
            label="Name"
            class="w-full"
            variant="outlined"
            density="comfortable"
            v-model="form.name"
            :error-messages="form.errors.name"
            @update:model-value="form.clearErrors('name')"
        />
        <VTextField
            type="date"
            label="Due Date"
            variant="outlined"
            density="comfortable"
            v-model="form.due_date"
            :error-messages="form.errors.due_date"
            @update:model-value="form.clearErrors('due_date')"
        />
        </div>
        <div class="grid md:grid-cols-2 gap-4">

        <VSelect
            color="primary"
            label="Priority"
            variant="outlined"
            density="comfortable"
            :items="['Low', 'Medium', 'High']"
            v-model="form.priority"
            :error-messages="form.errors.priority"
            @update:model-value="form.clearErrors('priority')"
        />
        <VSelect
            color="primary"
            label="Assign To"
            multiple
            closable-chips
            chips
            variant="outlined"
            density="comfortable"
            :items="users"
            item-value="id"
            item-title="name"
            v-model="form.users"
            :error-messages="form.errors.users"
            @update:model-value="form.clearErrors('users')"
        />
      </div>

      <Editor
          label="Instructions"
          v-model="form.description"
          :error="form.errors.description"
          @update:model-value="form.clearErrors('description')"
      />


      <VTextarea
          color="primary"
          label="Comments"
          variant="outlined"
          density="comfortable"
          v-model="form.comments"
          :error-messages="form.errors.comments"
          @update:model-value="form.clearErrors('comments')"
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
:deep(.mdi-close-circle) {
  @apply text-primary-500
}

</style>
