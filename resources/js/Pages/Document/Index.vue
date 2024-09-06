<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import {computed, ref} from "vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import {useCrud} from "@/Composables/useCrud.js";
import PageHeader from "@/Components/Global/PageHeader.vue";
import DocumentForm from "@/Pages/Document/DocumentForm.vue";
import ActionDownload from "@/Components/Common/Button/ActionDownload.vue";
import StatusBadge from "@/Components/Common/Chip/StatusBadge.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";
import {useFormat} from "@/Composables/useFormat.js";

const {date} = useFormat()

const tableHeader = [
    {label: 'Name', field: 'name'},
    {label: 'Category', field: 'category'},
    {label: 'Description', field: 'description'},
    {label: 'Status', field: 'status', align: 'center'},
    {label: 'Author', field: 'user', align: 'center'},
    {label: 'Date Updated', field: 'updated_at', align: 'center'},
    {label: 'Date Updated', field: 'updated_at', align: 'center'},
    {label: 'Actions', field: 'action', width: '5%'},
]

const documents = computed(() => usePage().props.documents);
const store_id = computed(() => usePage().props.store_id);

const showDocumentForm = ref(false)

const documentData = ref({});

const editData = (data) => {
    documentData.value = {...data}
    showDocumentForm.value = true;
}

const {destroy} = useCrud();
const destroyData = (id) => {
    destroy(route('admin.documents.destroy', id))
}
const title = 'Documents'
const pages = [
  {name: 'Documents', href: '#', current: true},
]
</script>

<template>
    <Head title="Document"/>
    <DocumentForm
        v-model="showDocumentForm"
        :store-id="store_id"
        :data="documentData"
    />
    <AuthenticatedLayout>
      <PageHeading :title="title" :pages="pages">
        <template #action>
          <div class="space-x-4">
            <VBtn @click="showDocumentForm = true" variant="outlined" color="primary">
              <i class="bi bi-plus mr-1"></i>
              Create
            </VBtn>
          </div>
        </template>
      </PageHeading>
        <div class="overflow-y-auto">
            <div class="bg-white rounded-lg p-6">
                <DataTable
                    class="mb-12"
                    :columns="tableHeader"
                    :data="documents"
                    :filter-link="route('admin.documents.index')"
                >
                    <template #column_name="{props}">
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="font-semibold text-sm">{{ props.name }}</p>
                                <span class="text-sm">{{ props.email }}</span>
                            </div>
                        </div>
                    </template>
                    <template #column_status="{props}">
                        <div class="flex items-center justify-center gap-3">
                            <StatusBadge :status="props.status"/>
                        </div>
                    </template>
                    <template #column_user="{props}">
                        <div class="flex items-center justify-center gap-3">
                            {{props.user?.name}}
                        </div>
                    </template>
                    <template #column_created_at="{props}">
                        <div class="flex items-center justify-center gap-3">
                            {{date(props.created_at)}}
                        </div>
                    </template>
                    <template #column_updated_at="{props}">
                        <div class="flex items-center justify-center gap-3">
                            {{date(props.updated_at)}}
                        </div>
                    </template>
                    <template #column_action="{props}">
                        <div class="flex justify-end items-center">
                            <ActionDownload link v-if="props.file_url" :to="props.file_url" />
                            <ActionEdit @click="editData(props)"/>
                            <ActionDelete @click="destroyData(props.id)"/>
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
