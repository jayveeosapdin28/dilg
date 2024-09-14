<script setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
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

const data = computed(()=> usePage().props.data)
const documents = computed(()=> usePage().props.documents)
const file = computed(()=> usePage().props.submitted)

const {hasRole} = useRole()
const {date} = useFormat()
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
const removeFile = () =>{
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
  {label: 'Action', field: 'file_url',align: 'right'},
]
</script>

<template>
    <Head :title="title"/>
    <AuthenticatedLayout>
        <PageHeading :title="title" :pages="pages"></PageHeading>
        <div class="text-slate-500 space-y-1 mt-4 bg-white rounded-lg shadow-lg p-6">
            <p>{{data.description}}</p>
            <p>Priority: <b>{{data.priority}}</b></p>
            <p>Due Date: <b>{{date(date.due_date)}}</b></p>
        </div>
        <div  v-if="hasRole('Super Admin') || hasRole('Admin')" class="mt-8 bg-white rounded-lg shadow-lg p-6  h-full overflow-y-auto space-y-4">
            <h2 class="font-semibold text-xl">Submitters List</h2>
            <DataTable
              :searchable="false"
              class="mb-12"
              :columns="tableHeader"
              :data="documents"
              :filter-link="route('admin.tasks.show', data.id)"
          >
            <template #column_name="{props}">
              <div class="flex items-center ">
                {{props.user?.name}}
              </div>
            </template>
            <template #column_file_url="{props}">
              <div class="flex justify-end items-center">
                <ActionDownload link v-if="props.file_url" :to="props.file_url" />
              </div>
            </template>
          </DataTable>
        </div>
        <div v-if="hasRole('User')" class="mt-8 bg-white rounded-lg shadow-lg p-6 space-y-4">
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
          <div>
            <a v-if="file" class="text-primary-500 hover:underline cursor-pointer" :href="file.file_url" target="_blank">Download your document</a>
          </div>
            <VBtn @click="handleSubmitDocument" :disabled="form.processing || !form.file" class="" variant="flat" color="primary">
                Submit Document
            </VBtn>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
