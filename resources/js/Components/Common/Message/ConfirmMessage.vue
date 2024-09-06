<template>
  <Transition name="nested">
    <div
        class="fixed top-0 left-0 w-full h-full bg-primary-500 bg-opacity-20 flex items-center justify-center outer z-50"
        v-if="message.isShow"
    >
      <div class="bg-white px-4 rounded-lg shadow-md relative inner min-w-[30rem] max-w-[35rem]">
        <div class="text-lg">

          <div class="text-center px-4 py-8">
            <div class="text-6xl mb-4 text-yellow-400">
              <i class="bi bi-exclamation-circle"></i>
            </div>
            <div class="text-2xl font-semibold mb-4">
              {{ message.title }}
            </div>
            <div>
              {{ message.message }}
            </div>
          </div>
          <div class="flex justify-around p-4">
            <VBtn @click="message.handleConfirmation(false)" variant="text" color="error">No</VBtn>
            <VBtn @click="message.handleConfirmation(true)" variant="text" color="info">Yes</VBtn>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>

import {ConfirmMessage} from "@/Components/Common/Message/useConfirmMessage.js";

const message = ConfirmMessage()


</script>

<style scoped>

.nested-enter-active, .nested-leave-active {
  transition: all 0.2s ease-in-out;
}

.nested-leave-active {
  transition-delay: 0.25s;
}

.nested-enter-from,
.nested-leave-to {
  opacity: 0;
}


.nested-enter-active .inner,
.nested-leave-active .inner {
  transition: all 0.2s ease-in-out;
}

.nested-enter-active .inner {
  transition: all 0.2s ease-in-out;
}

.nested-enter-from .inner,
.nested-leave-to .inner {
  transform: translateY(-30px);
  opacity: 0.001;
}
</style>
