<script setup>

import Pagination from "@/Components/Common/Table/Pagination.vue";
import {ref, computed, watch} from "vue";
import {router, usePage} from "@inertiajs/vue3";
import {debounce} from "lodash";


const props = defineProps({
  columns: Array,
  data: Object,
  searchable: {
    type: Boolean,
    default: true
  },
  modelValue: String,
  withPagination: {
    type: Boolean,
    default: true
  },
  searchPlaceholder: {
    type: String,
    default: 'Search'
  },
  filterLink: String,
})
const searchInput = ref(null);
const requestParams = computed(() => usePage().props.request);

let filter = ref({
  query: requestParams?.value?.query ?? null,
  order_by: requestParams?.value?.order_by ?? null,
  sort_by: requestParams?.value?.sort_by ?? null,
  pages: requestParams?.value?.pages ?? 10,
  page: requestParams?.value?.page ?? null,
});

const applyFilter = async () => {
  let params = {...filter.value};
  await clearEmptyKeys(params);
  router.get(props.filterLink, params, {
    preserveState: true,
    preserveScroll: true,
  });
};

const sort = (column, sortable) => {
  updateQuery();
  if (!sortable) {
    if (column === filter.value.sort_by) {
      filter.value.order_by = filter.value.order_by == "asc" ? "desc" : "asc";
    } else {
      filter.value.sort_by = column;
      filter.value.order_by = "asc";
    }
    filterData();
  }
};

const internalValue = computed({
  set: (val) => {
    emit('update:modelValue', val)
  },
  get: () => props.modelValue
});

const getSortClass = (column) => {
  if (column === filter.value.sort_by) {
    return `sorted-${filter.value.order_by}`;
  }
  return "";
};

const getIcon = () => {
  if (filter.value.order_by === "asc") {
    return "bi bi-arrow-up";
  }
  return "bi bi-arrow-down";
};

function clearEmptyKeys(array) {
  for (const key in array) {
    if (
        (Array.isArray(array[key]) && array[key].length === 0) ||
        array[key] === null ||
        array[key] === ""
    ) {
      delete array[key];
    }
  }
}

const updateQuery = () => {
  filter.value.page = 1;
};
const filterData = debounce((newValue, array) => {
  // console.log(props.table_name);
  applyFilter();
  updateQuery()
}, 100);

watch(
    filter,
    (newValue, oldValue) => {
      filterData();
    },
    {deep: true}
);

watch(() => props.modelValue,
    (newValue, oldValue) => {
      Object.keys(filter.value).forEach((key) => {
        filter.value[key] = null;
      })
      applyFilter();
      updateQuery()
    }
);

</script>

<template>
  <div class="">
    <div v-if="searchable" class="mb-4 flex justify-between items-center">
      <div class="min-w-72">
        <VTextField
            variant="outlined"
            density="compact"
            clearable
            color="primary"
            v-model="filter.query"
            :label="searchPlaceholder"/>
      </div>
      <slot name="table-toolbar"/>
    </div>
    <table class="w-full" :class="{'h-[calc(30vh)]' : data && data.data?.length < 1}">
      <thead class="rounded border-b">
      <template v-for="column in columns">
        <th :align="column.align ? column.align : 'left'"
            class="text-sm font-semibold uppercase cursor-pointer text-gray-500 p-3"
            :class="getSortClass(column.field)"
            :style="{width: column.width ?? null}"
            @click="column.sortable !== 'No' ? sort(column.field, column.prevent_sort) : null"
        >
          <i v-if=" filter.sort_by === column.field && !(column.prevent_sort)"
             :class="getIcon()">
          </i>
          {{ column.label }}
        </th>
      </template>
      <slot name="table-header"/>
      </thead>
      <tbody>
      <template v-if="data && data.data?.length < 1">
        <tr>
          <td colspan="99" class="text-center py-6 px-3 text-sm text-gray-600">
            <div class="flex justify-center items-center">
              <div class="">
                <img class="w-[10rem] opacity-40" src="/img/default/empty-box.png">
                <p class="text-gray-300 text-lg mt-3">Data not found</p>
              </div>
            </div>
          </td>
        </tr>
      </template>
      <template v-else v-for="item in data.data">
        <tr class="even:bg-primary-50 rounded hover:bg-primary-100">
          <template v-for="column in columns">
            <td :align="column.align ? column.align : 'left'" class="p-3  text-sm text-gray-600">
              <slot :name="`column_${column.field}`" :props="item">
                {{ item[column.field] }}
              </slot>
            </td>
          </template>
        </tr>
      </template>
      </tbody>
    </table>


    <div class="mt-8">
      <Pagination
          v-if="data && data.data?.length > 0 && withPagination"
          :total="data.total ?? 0"
          :from="data.from ?? 0"
          :to="data.to ?? 0"
          :links="data.links ?? []"
          :current_page="data.current_page ?? null"
          :next_page_url="data.next_page_url ?? '#'"
          :prev_page_url="data.prev_page_url ?? '#'"
      />
    </div>
  </div>
</template>

<style scoped>

</style>
