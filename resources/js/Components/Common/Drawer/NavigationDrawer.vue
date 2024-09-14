<script setup>

import {computed} from "vue";

const props = defineProps({
  modelValue: String,
  static: Boolean,
  width: String,
});
const emit = defineEmits(['update:modelValue']);


const internalValue = computed({
  set: (val) => {
    emit('update:modelValue', val)
  },
  get: () => props.modelValue
});
</script>

<template>
  <Transition name="nested">
    <div v-if="internalValue" class="fixed h-screen w-full bg-primary-500 bg-opacity-50 flex justify-end z-10">
      <div :class="width ? `sm:w-[${width}rem]` : 'sm:w-[25rem]'" class="shadow bg-white w-full  py-4 px-6 inner flex flex-col overflow-y-auto">
        <slot name="header"/>
        <div class="flex-grow py-4">
          <slot/>
        </div>
        <slot name="footer"/>
      </div>
    </div>
  </Transition>
</template>

<style scoped>

.nested-enter-active, .nested-leave-active {
  transition: all .3s ease-in-out;
}

.nested-leave-active {
  transition-delay: .1s;
}

.nested-enter-from,
.nested-leave-to {
  opacity: 0;
}


.nested-enter-active .inner,
.nested-leave-active .inner {
  transition: all .3s;
}

.nested-enter-active .inner {
  transition: all .3s;
}

.nested-enter-from .inner,
.nested-leave-to .inner {
  transform: translateX(25rem);
}
</style>
