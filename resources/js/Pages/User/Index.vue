<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import {computed, ref} from "vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import {useCrud} from "@/Composables/useCrud.js";
import PageHeader from "@/Components/Global/PageHeader.vue";
import UserForm from "@/Pages/User/UserForm.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";
import {useRole} from "@/Composables/useRole.js";


const tableHeader = [
    {label: 'Name', field: 'name'},
    {label: 'Role', field: 'role'},
    {label: 'Actions', field: 'action', width: '5%'},
]

const {hasRole} = useRole()
const users = computed(() => usePage().props.users);
const store_id = computed(() => usePage().props.store_id);

const showUserForm = ref(false)

const userData = ref({});

const editData = (data) => {
    userData.value = {...data}
    showUserForm.value = true;
}

const {destroy} = useCrud();
const destroyData = (id) => {
    destroy(route('admin.users.destroy', id))
}
const title = 'Users'
const pages = [
  {name: 'Users', href: '#', current: true},
]
</script>

<template>
    <Head title="User"/>
    <UserForm
        v-model="showUserForm"
        :store-id="store_id"
        :data="userData"
    />
    <AuthenticatedLayout>
      <PageHeading :title="title" :pages="pages">
        <template #action>
          <div class="space-x-4">
            <VBtn v-if="hasRole('Super Admin') || hasRole('Admin')" @click="showUserForm = true" variant="outlined" color="primary">
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
                    :data="users"
                    :filter-link="route('admin.users.index')"
                >
                    <template #column_name="{props}">
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="font-semibold text-sm">{{ props.name }}</p>
                                <span class="text-sm">{{ props.email }}</span>
                            </div>
                        </div>
                    </template>
                    <template #column_action="{props}">
                        <div class="flex justify-end items-center">
                            <ActionEdit v-if="hasRole('Super Admin') || hasRole('Admin')" @click="editData(props)"/>
                            <ActionDelete v-if="hasRole('Super Admin') || hasRole('Admin')" @click="destroyData(props.id)"/>
                        </div>
                    </template>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
