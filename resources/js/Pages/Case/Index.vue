<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import {computed, ref} from "vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import {useCrud} from "@/Composables/useCrud.js";
import PageHeader from "@/Components/Global/PageHeader.vue";
import CaseForm from "@/Pages/Case/CaseForm.vue";
import StatusBadge from "@/Components/Common/Chip/StatusBadge.vue";
import {useFormat} from "@/Composables/useFormat.js";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";

const {date} = useFormat();

const tableHeader = [
  {label: 'Name', field: 'name'},
  {label: 'Open', field: 'date_open'},
  {label: 'Closed', field: 'date_closed'},
  {label: 'Status', field: 'status', align: 'center'},
  {label: 'Actions', field: 'action', width: '5%'},
]

const cases = computed(() => usePage().props.cases);
const store_id = computed(() => usePage().props.store_id);

const showCaseForm = ref(false)

const caseData = ref({});

const editData = (data) => {
  caseData.value = {...data}
  showCaseForm.value = true;
}

const {destroy} = useCrud();
const destroyData = (id) => {
  destroy(route('admin.cases.destroy', id))
}
const title = 'Cases'
const pages = [
  {name: 'Cases', href: '#', current: true},
]
</script>

<template>
  <Head title="Case"/>
  <CaseForm
      v-model="showCaseForm"
      :store-id="store_id"
      :data="caseData"
  />
  <AuthenticatedLayout>
    <PageHeading :title="title" :pages="pages">
      <template #action>
        <div class="space-x-4">
          <VBtn @click="showCaseForm = true" variant="outlined" color="primary">
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
            :data="cases"
            :filter-link="route('admin.cases.index')"
        >
          <template #column_name="{props}">
            <div class="flex items-center gap-3">
              <div>
                <p class="font-semibold text-sm">{{ props.name }}</p>
              </div>
            </div>
          </template>
          <template #column_date_open="{props}">
            {{ date(props.date_open) }}
          </template>
          <template #column_date_closed="{props}">
            {{ date(props.date_closed) }}
          </template>
          <template #column_status="{props}">
            <div class="flex items-center justify-center gap-3">
              <StatusBadge :status="props.status"/>
            </div>
          </template>
          <template #column_action="{props}">
            <div class="flex justify-end items-center">
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
