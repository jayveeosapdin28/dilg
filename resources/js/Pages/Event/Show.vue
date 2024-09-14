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

const data = computed(() => usePage().props.data)
const documents = computed(() => usePage().props.documents)
const file = computed(() => usePage().props.submitted)

const {date} = useFormat()
const {submitForm} = useCrud();

const title = data.value?.event_name

</script>

<template>
  <Head :title="title"/>
  <AuthenticatedLayout>
    <div class="h-full overflow-y-auto pb-8">
      <div class="max-w-5xl mx-auto px-6 ">
        <h2 class="font-semibold text-slate-800 text-4xl">{{ title }}</h2>
        <div class="text-slate-600 mt-4">
          <p>Posted Date: <b>{{ date(data.created_at) }}</b></p>
          <p>From: <b>{{ date(data.date_open) }}</b></p>
          <p>To: <b>{{ date(data.date_close) }}</b></p>
          <p>Location: <span class="text-primary-400">{{ date(data.date_close) }}</span></p>
        </div>
        <div class="mt-12">
          <h2 class="text-primary-400 mb-4 font-semibold">Details:</h2>
          <div class="prose prose-slate" v-html="data.description"></div>
        </div>

      </div>
    </div>

  </AuthenticatedLayout>

</template>

<style scoped>

</style>
