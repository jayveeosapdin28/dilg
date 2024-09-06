<script setup>
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    TransitionChild,
    TransitionRoot
} from "@headlessui/vue";
import { Cog6ToothIcon, XMarkIcon } from "@heroicons/vue/24/outline/index.js";
import {navigation} from "@/Utils/links.js";
import {ChevronRightIcon} from "@heroicons/vue/20/solid/index.js";
import {Link} from "@inertiajs/vue3";

defineProps({
    sidebarOpen:Boolean
})

const emit = defineEmits(['toggle:sidebarOpen'])
const toggleSidebar = (value) =>{
    emit('toggle:sidebarOpen', value)
}




</script>

<template>
    <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog as="div" class="relative z-50 lg:hidden" @close="toggleSidebar(false)">
            <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                             enter-from="opacity-0" enter-to="opacity-100"
                             leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                             leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-900/80"/>
            </TransitionChild>

            <div class="fixed inset-0 flex">
                <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                 enter-from="-translate-x-full" enter-to="translate-x-0"
                                 leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                 leave-to="-translate-x-full">
                    <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                        <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
                                         enter-to="opacity-100" leave="ease-in-out duration-300"
                                         leave-from="opacity-100" leave-to="opacity-0">
                            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                <button type="button" class="-m-2.5 p-2.5" @click="toggleSidebar(false)">
                                    <span class="sr-only">Close sidebar</span>
                                    <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                </button>
                            </div>
                        </TransitionChild>
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-primary-600 px-6 pb-4">
                          <div class="flex h-16 shrink-0 items-center justify-center py-2">
                            <img class="h-full w-auto" src="/img/logo/dilg_logo.svg"
                                 alt="DILG"/>
                          </div>
                          <nav class="flex flex-1 flex-col">
                            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                              <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                  <li v-for="item in navigation" :key="item.label">
                                    <Link v-if="!item.children" :href="route(item.route)" :class="[route().current(item.base_route) ? 'bg-primary-800' : 'hover:bg-primary-100  hover:!text-primary-600', 'block rounded-md py-2 pr-2 pl-10 text-sm leading-6 font-semibold text-white']">
                                      <div class="flex gap-6 ">
                                        <i :class="item.icon"></i>
                                        {{ item.label }}
                                      </div>
                                    </Link>
                                    <Disclosure :default-open="route().current(item.base_route)" as="div" v-else v-slot="{ open }">
                                      <DisclosureButton :class="['flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-white justify-between']">
                                   <span>
                                       <i :class="item.icon"></i>
                                      {{ item.label }}
                                   </span>
                                        <ChevronRightIcon :class="[open ? 'rotate-90 text-white' : 'text-white', 'h-5 w-5 shrink-0']" aria-hidden="true" />
                                      </DisclosureButton>
                                      <DisclosurePanel as="ul" class="mt-1 px-2">
                                        <li v-for="subItem in item.children" :key="subItem.label">
                                          <Link :href="route(subItem.route)" :class="[route().current(subItem.current) ? 'bg-primary-800 font-semibold' : 'hover:font-bold ', 'block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-white']">{{ subItem.label }}</Link>
                                        </li>
                                      </DisclosurePanel>
                                    </Disclosure>
                                  </li>
                                </ul>
                              </li>
                            </ul>
                          </nav>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>

</style>
