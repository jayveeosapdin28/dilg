<script setup>
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";
import {useRole} from "@/Composables/useRole.js";
import {useFormat} from "@/Composables/useFormat.js";
import FileUploader from "@/Components/Common/Form/FileUploader.vue";
import {computed} from "vue";
import CreateButton from "@/Components/Common/Button/CreateButton.vue";
import BackButton from "@/Components/Common/Button/BackButton.vue";
import {useCrud} from "@/Composables/useCrud.js";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import StatusBadge from "@/Components/Common/Chip/StatusBadge.vue";
import ActionView from "@/Components/Common/Button/ActionView.vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import ActionDownload from "@/Components/Common/Button/ActionDownload.vue";

const data = computed(() => usePage().props.data)
const documents = computed(() => usePage().props.documents)
const file = computed(() => usePage().props.submitted)

const {hasRole} = useRole()
const {date, mimeTypeIcon} = useFormat()
const {submitForm} = useCrud();

const title = data.value?.name
const pages = [
  {name: data.value?.name, href: '#', current: true},
]
let form = useForm({
  task_id: data.value?.id,
  file: null,
  remove_file: null,
})
const removeFile = () => {
  form.remove_file = true;
}

const handleSubmitDocument = async () => {
  await submitForm(form, `admin.task.submit`, null, true, true)
      .then(() => {
        form.reset();
      })
}
const tableHeader = [
  {label: 'Name', field: 'name'},
  {label: 'Action', field: 'file_url', align: 'right'},
]
</script>

<template>
  <Head :title="title"/>
  <AuthenticatedLayout>
    <div class="pb-12">
      <Link :href="route('admin.tasks.index')">
        <VBtn  variant="outlined" color="primary">
          <i class="bi bi-chevron-left mr-1"></i>
          Back
        </VBtn>
      </Link>
    </div>

    <div class="h-full overflow-y-auto pb-8">
      <div class="max-w-5xl mx-auto px-6 ">
        <h2 class="font-semibold text-slate-800 text-4xl">{{ title }}</h2>
        <div class="text-slate-600 mt-4">
          <p>Posted Date: <b>{{ date(data.created_at) }}</b></p>
          <p>Due Date: <b>{{ date(data.due_date) }}</b></p>
          <p>Priority: <b class="text-primary-400">{{ data.priority.toUpperCase() }}</b></p>
          <p>Status: <b class="text-primary-400">{{ data.status?.toUpperCase() }}</b></p>
        </div>
        <div class="mt-12">
          <h2 class="text-primary-400 mb-4 font-semibold">Instructions:</h2>
          <div class="prose prose-slate" v-html="data.description"></div>
        </div>


        <div v-if="hasRole('Super Admin') || hasRole('Admin')"
             class="mt-16  h-full overflow-y-auto space-y-4">
          <h2 class="text-primary-400  mb-4 font-semibold">Submitters List:</h2>
          <DataTable
              v-if="documents.data?.length"
              :searchable="false"
              class="mb-12"
              :columns="tableHeader"
              :data="documents"
              :filter-link="route('admin.tasks.show', data.id)"
          >
            <template #column_name="{props}">
              <div class="flex items-center ">
                {{ props.user?.name }}
              </div>
            </template>
            <template #column_file_url="{props}">
              <div class="flex justify-end items-center">
                <ActionDownload link v-if="props.file_url" :to="props.file_url"/>
              </div>
            </template>
          </DataTable>
        </div>
        <div v-if="hasRole('User')" class="mt-14 bg-white  space-y-8">
          <div v-if="file">
            <h2 class="text-primary-400  mb-4 font-semibold">My work:</h2>
            <a class="text-primary-500 hover:underline cursor-pointer font-semibold" :href="file.file_url"
               target="_blank">
              <div class="bg-white rounded border border-primary-600 p-4 flex items-center gap-2">
                <i :class="mimeTypeIcon(file.file?.mime_type)" class="text-2xl text-primary-500"></i>
                <span class="text-primary-600">{{ file.file?.file_name }}</span>
              </div>
            </a>
          </div>
          <template v-else>
            <FileUploader
                :id="`${form.id}-id`"
                :key="`${form.id}-key`"
                ref="image_uploader"
                v-model="form.file"
                placeholder="Drop or select document file here"
                :model-files="form.file_url"
                @remove-file="removeFile"
                :error-messages="form.errors.file"
                @update:model-value="form.clearErrors('file')"
            />
            <VBtn @click="handleSubmitDocument" :disabled="form.processing || !form.file" class="" variant="flat"
                  color="primary">
              Submit Document
            </VBtn>
          </template>
        </div>
      </div>
    </div>

  </AuthenticatedLayout>

</template>

<style scoped>

</style>
