<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, usePage} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import {computed, ref} from "vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import {useCrud} from "@/Composables/useCrud.js";
import PageHeader from "@/Components/Global/PageHeader.vue";
import EventForm from "@/Pages/Event/EventForm.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";
import {useRole} from "@/Composables/useRole.js";
import ActionView from "@/Components/Common/Button/ActionView.vue";

const tableHeader = [
    {label: 'Name', field: 'event_name'},
    {label: 'Location', field: 'location'},
    {label: 'From', field: 'date_open'},
    {label: 'To', field: 'date_close'},
    {label: 'Actions', field: 'action', width: '5%'},
]

const events = computed(() => usePage().props.events);
const store_id = computed(() => usePage().props.store_id);

const showEventForm = ref(false)

const eventData = ref({});

const {isInRole, hasRole} = useRole()

const editData = (data) => {
    eventData.value = {...data}
    showEventForm.value = true;
}

const {destroy} = useCrud();
const destroyData = (id) => {
    destroy(route('admin.events.destroy', id))
}
const title = 'Events'
const pages = [
  {name: 'Events', href: '#', current: true},
]

</script>

<template>
    <Head title="Event"/>
    <EventForm
        v-model="showEventForm"
        :store-id="store_id"
        :data="eventData"
    />
    <AuthenticatedLayout>
      <PageHeading :title="title" :pages="pages">
        <template #action>
          <div v-if="isInRole(['Super Admin', 'Admin'])" class="space-x-4">
            <VBtn @click="showEventForm = true" variant="outlined" color="primary">
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
                    :data="events"
                    :filter-link="route('admin.events.index')"
                >
                    <template #column_event_name="{props}">
                        <div class="flex items-center gap-3">
                          <Link :href="route('admin.events.show',props.id)">
                                <p class="font-semibold text-sm hover:text-primary-600 hover:underline">{{ props.event_name }}</p>
                          </Link>
                        </div>
                    </template>
                    <template #column_action="{props}">
                        <div class="flex justify-end items-center">
                          <ActionView link :href="route('admin.events.show',props.id)"/>
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
