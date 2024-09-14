<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronRightIcon } from '@heroicons/vue/20/solid'
import {navigation} from "@/Utils/links.js";
import {Link} from "@inertiajs/vue3";
import {useRole} from "@/Composables/useRole.js";


const {isInRole} = useRole()

</script>

<template>
    <div class="flex z-0  grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-b from-primary-500 to-primary-600 px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center justify-center py-2">
          <img class="h-full w-auto" src="/img/logo/dilg_logo.svg"
               alt="DILG"/>
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <template v-for="item in navigation" :key="item.label">
                            <li v-if="isInRole(item.access)">
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
                        </template>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style scoped>

</style>
