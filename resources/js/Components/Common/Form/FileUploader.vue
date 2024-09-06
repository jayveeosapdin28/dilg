<script setup>

import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';


import FilepondPluginFilePoster from 'filepond-plugin-file-poster'
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import {computed, ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";


const props = defineProps({
    modelValue: String,
    modelFiles: String,
    error: String,
    label: {
        type: String,
    },
    name: String,
    placeholder: {
        type: String,
        default: 'Drop or select file here'
    },
    required: Boolean,
    errorMessages: String
})

const emit = defineEmits(['update:modelValue','update:modelFile','revert-file','remove-file'])
const file = ref(null);

const internalModel = computed({
    set: (val) => {
        emit('update:modelValue', val)
    },
    get: () => props.modelValue
});
const internalFiles = computed({
    set: (val) => {
        emit('update:modelFile', val)
    },
    get: () => props.modelFiles
});

watch(()=>internalFiles.value,()=>{
    if(internalModel.value){
        file.value = null;
        resetFilePond()
    }
})


const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilepondPluginFilePoster
);

const pond = ref(null);

const handleFilePondInit = () => {
    if(internalFiles.value){
        setTimeout(() => {
            file.value = [
                {
                    source: internalFiles.value,
                    options: {
                        type: 'local',
                        metadata: {
                            poster: internalFiles.value
                        }
                    }
                }
            ];
        }, 100);
    }else{
        file.value = null;
    }
}
const handleFilePondLoad = (response) => {
    internalModel.value = response
}
const handleFilePondRemove = (source, load, error) => {
    load()
    emit('remove-file')
}

const handleFilePondRevert = (uniqueFileId, load, error) => {
    load()
    emit('revert-file')
}

const resetFilePond = () => {
    pond.value.removeFiles();
};

defineExpose({
    resetFilePond
});

</script>

<template>
    <div class="mb-2 ">
        <label>{{label}}<span v-if="required" class="text-red-500">*</span></label>
        <FilePond
            name="file"
            ref="pond"
            :label-idle="placeholder"
            v-bind:allow-multiple="false"
            v-bind:server="{
          timeout: 7000,
          process: {
            url: '/upload-file',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN' : usePage().props.csrf_token
            },
            withCredentials: false,
            onload: handleFilePondLoad,
            onerror: () =>{},
          },
           remove: handleFilePondRemove,
           revert: handleFilePondRevert
        }"
            v-bind:files="file"
            v-on:init="handleFilePondInit"
            v-on:revert="handleFilePondRevert"
        />
        <div v-if="errorMessages">
            <small class="text-red-500">{{errorMessages}}</small>
        </div>
    </div>
</template>

<style scoped>

</style>
