<script setup>
import {computed, defineProps, ref} from 'vue';
import InputLabel from "@/Components/InputLabel.vue";
import Editor from '@tinymce/tinymce-vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
  modelValue: String,
  id: {
    type: String,
    default: 'name'
  },
  removable: Boolean,
  label: String,
  placeholder: String,
  error: String,
  required: Boolean,
  disabled: Boolean,
  rows: Number | String,
  autofocus: Boolean,
  type: {
    type: String,
    default: 'text'
  }
});

const emit = defineEmits(['update:modelValue','remove', 'init']);

const input = ref(null);

const internalValue = computed({
  set: (val) => {
    emit('update:modelValue', val)
  },
  get: () => props.modelValue
});

const editorReady = ref(false);
const editorInit = () =>{
  console.log('INIT')
}
</script>

<template>
  <div class="py-2 m-0 space-y-2 w-full relative" id="wyswyg-editor">
    <div v-if="removable" @click="$emit('remove')" class="h-6 w-6 absolute rounded-full bg-white border border-red-500 hover:scale-110 hover:border-red-600 cursor-pointer -right-1 -top-1 z-40">
      <XMarkIcon class="text-red-500 hover:text-red-600"/>
    </div>
    <InputLabel v-if="label" for="email" :value="label" :required="required"/>
    <Editor
        tinymce-script-src="/js/tinymce/tinymce.min.js"
        :init="{
        toolbar_mode: 'sliding',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker markdown',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      }"
        initial-value="Welcome to TinyMCE!"
        v-model="internalValue"
        @init="() => emit('init')"
    />
    <span v-if="error?.length" class="text-red-500 text-sm">{{ error }}</span>
  </div>
</template>

<style scoped>
/* Add orange border and outline on focus */
#wyswyg-editor .tox-tinymce.tox-tinymce--focused,
#wyswyg-editor .tox-edit-area iframe:focus,
#wyswyg-editor .tox-edit-area iframe {
  border: 2px solid orange !important;
  outline: 2px solid orange !important; /* This targets the internal iframe */
}

/* Default border for TinyMCE */
#wyswyg-editor .tox-tinymce {
  border: 1px solid #d1d5db; /* Default Tailwind gray-300 */
}
</style>
