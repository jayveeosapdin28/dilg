<script setup>
import {computed, onMounted, ref, watch} from "vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import {useCrud} from "@/Composables/useCrud.js";
import Loading from "@/Components/Global/Loading.vue";
import NavigationDrawer from "@/Components/Common/Drawer/NavigationDrawer.vue";
import Editor from "@/Components/Common/Form/Editor.vue";

const props = defineProps({
  modelValue: [Boolean, String],
  storeId: [String, Number],
  data: Object,
})

const emit = defineEmits(['update:modelValue', 'close', 'on-success'])

const cities = computed(() => usePage().props.cities)
const provinces = computed(() => usePage().props.provinces)
const barangays = computed(() => usePage().props.barangays)
const request = computed(() => usePage().props.request)

let form = useForm({
  id: null,
  event_name: props.event_name,
  description: props.description,
  date_open: props.date_open,
  date_close: props.date_close,
  status: props.status,
  state: props.state,
  city: props.city,
  street: props.street,
  barangay: props.barangay,
})

watch(() => props.data, (val) => {
  form.id = val.id ?? null
  form.event_name = val.event_name ?? null
  form.description = val.description ?? null
  form.date_open = val.date_open ?? null
  form.date_closed = val.date_closed ?? null
  form.status = val.status ?? null
});

const filter = ref({
  city: null,
  state: null,
  barangay: null,
})

watch(() => form.state, (val) => {
  filter.value.state = val
  if (!val) {
    form.city = null;
  }
  router.get(route('admin.events.index'), filter.value, {
    preserveState: true, preserveScroll: true
  })
})

watch(() => form.city, (val) => {
  filter.value.city = val
  if (!val) {
    form.barangay = null;
  }
  router.get(route('admin.events.index'), filter.value, {
    preserveState: true, preserveScroll: true
  })
})

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


watch(() => internalValue.value, () => {
  if (!internalValue.value) {
    form.reset();
  }

})

onMounted(() => {
  if (request.value.city && !form.state) {
    form.city = request.value.city;
  }
  if (request.value.state && !form.state) {
    form.state = request.value.state;
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
      width="60"
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
      <div class="md:grid grid-cols-2 gap-4">
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
      </div>

      <div class="md:grid grid-cols-2 gap-4">
        <VSelect
            clearable
            color="primary"
            label="Province"
            variant="outlined"
            density="comfortable"
            :items="provinces"
            item-title="label"
            item-value="value"
            v-model="form.state"
            :error-messages="form.errors.state"
            @update:model-value="form.clearErrors('state')"
        />

        <VSelect
            clearable
            :disabled="!cities.length"
            color="primary"
            label="City / Municipality"
            variant="outlined"
            density="comfortable"
            :items="cities"
            item-title="label"
            item-value="value"
            v-model="form.city"
            :error-messages="form.errors.city"
            @update:model-value="form.clearErrors('city')"
        />
      </div>
      <div class="md:grid grid-cols-2 gap-4">
        <VSelect
            clearable
            :disabled="!barangays.length"
            color="primary"
            label="Barangay"
            variant="outlined"
            density="comfortable"
            :items="barangays"
            item-title="label"
            item-value="value"
            v-model="form.barangay"
            :error-messages="form.errors.barangay"
            @update:model-value="form.clearErrors('barangay')"
        />

        <VTextField
            color="primary"
            label="Street"
            variant="outlined"
            density="comfortable"
            v-model="form.street"
            :error-messages="form.errors.street"
            @update:model-value="form.clearErrors('street')"
        />
      </div>
      <Editor
          label="Details"
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
