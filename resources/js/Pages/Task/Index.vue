<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage,Link} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import {computed, onMounted, ref} from "vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import {useCrud} from "@/Composables/useCrud.js";
import PageHeader from "@/Components/Global/PageHeader.vue";
import TaskForm from "@/Pages/Task/TaskForm.vue";
import StatusBadge from "@/Components/Common/Chip/StatusBadge.vue";
import PriorityBadge from "@/Components/Common/Chip/PriorityBadge.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";
import {useRole} from "@/Composables/useRole.js";
import ActionView from "@/Components/Common/Button/ActionView.vue";
import {useFormat} from "@/Composables/useFormat.js";


const {hasRole} = useRole()
const {date} = useFormat()


const tableHeader = ref([
  {label: 'Name', field: 'name'},
  {label: 'Status', field: 'status',align: 'center'},
  {label: 'Priority', field: 'priority', align: 'center'},
  {label: 'Submitted Documents', field: 'documents_count'},
  {label: 'Comment', field: 'comments'},
  {label: 'Due Date', field: 'due_date'},
  {label: 'Actions', field: 'action', width: '5%'},
])

const tasks = computed(() => usePage().props.tasks);
const store_id = computed(() => usePage().props.store_id);

const showTaskForm = ref(false)

const taskData = ref({});

const editData = (data) => {
    taskData.value = {...data}
    showTaskForm.value = true;
}

const {destroy} = useCrud();
const destroyData = (id) => {
    destroy(route('admin.tasks.destroy', id))
}
const title = 'Tasks'
const pages = [
  {name: 'Tasks', href: '#', current: true},
]

onMounted(()=>{
  if(hasRole('Super Admin') || hasRole('Admin')){
    tableHeader.value = tableHeader.value.filter(header => header.field !== 'status');
  }
})
</script>

<template>
    <Head title="Task"/>
    <TaskForm
        v-model="showTaskForm"
        :store-id="store_id"
        :data="taskData"
    />
    <AuthenticatedLayout>
      <PageHeading :title="title" :pages="pages">
        <template #action>
          <div class="space-x-4">
            <VBtn v-if="hasRole('Super Admin') || hasRole('Admin')" @click="showTaskForm = true" variant="outlined" color="primary">
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
                    :data="tasks"
                    :filter-link="route('admin.tasks.index')"
                >
                    <template #column_name="{props}">
                        <div class="flex items-center gap-3">
                            <Link :href="route('admin.tasks.show',props.id)">
                                <p class="font-semibold text-sm hover:text-primary-600 hover:underline">{{ props.name }}</p>
                            </Link>
                        </div>
                    </template>
                  <template #column_priority="{props}">
                    <div class="flex items-center justify-center gap-3">
                      <PriorityBadge :status="props.priority"/>
                    </div>
                  </template>
                  <template #column_status="{props}">
                    <div class="flex items-center justify-center gap-3">
                      <StatusBadge :status="props.status"/>
                    </div>
                  </template>
                    <template #column_due_date="{props}">
                   {{ date(props.due_date)}}
                  </template>

                    <template #column_action="{props}">
                        <div class="flex justify-end items-center">
                            <ActionView link :href="route('admin.tasks.show',props.id)"/>
                            <template v-if="hasRole('Super Admin') || hasRole('Admin')">
                                <ActionEdit @click="editData(props)"/>
                                <ActionDelete @click="destroyData(props.id)"/>
                            </template>
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
