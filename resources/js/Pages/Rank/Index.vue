<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import DataTable from "@/Components/Common/Table/DataTable.vue";
import {computed, ref} from "vue";
import ActionDelete from "@/Components/Common/Button/ActionDelete.vue";
import ActionEdit from "@/Components/Common/Button/ActionEdit.vue";
import {useCrud} from "@/Composables/useCrud.js";
import PageHeader from "@/Components/Global/PageHeader.vue";
import RankForm from "@/Pages/Rank/RankForm.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";


const tableHeader = [
    {label: 'Name', field: 'name'},
    {label: 'Score', field: 'total_score', width: '10%', align:'center'},
]

const ranks = computed(() => usePage().props.data);
const store_id = computed(() => usePage().props.store_id);

const showRankForm = ref(false)

const rankData = ref({});

const editData = (data) => {
    rankData.value = {...data}
    showRankForm.value = true;
}

const {destroy} = useCrud();
const destroyData = (id) => {
    destroy(route('admin.ranks.destroy', id))
}
const title = 'Ranks'
const pages = [
  {name: 'Ranks', href: '#', current: true},
]
</script>

<template>
    <Head title="Rank"/>
    <RankForm
        v-model="showRankForm"
        :store-id="store_id"
        :data="rankData"
    />
    <AuthenticatedLayout>
      <PageHeading :title="title" :pages="pages">
        <template #action>
          <div class="space-x-4">
            <VBtn @click="showRankForm = true" variant="outlined" color="primary">
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
                    :data="ranks"
                    :filter-link="route('admin.ranks.index')"
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
