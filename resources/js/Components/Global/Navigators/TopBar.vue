<script setup>
import {usePage, Link, router} from "@inertiajs/vue3";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {Bars3Icon} from "@heroicons/vue/24/outline/index.js";
import {ChevronDownIcon, MagnifyingGlassIcon} from "@heroicons/vue/20/solid/index.js";
import {userNavigation} from "@/Utils/links.js";
import {computed, nextTick, onMounted} from "vue";

const emit = defineEmits(['toggle:sidebarOpen'])
const toggleSidebar = (value) =>{
    emit('toggle:sidebarOpen', value)
}

const user = usePage().props.auth.user
const notifications =  computed(()=>usePage().props.notifications);
onMounted(()=>{
    Echo.private(`notification.${usePage().props.auth.user.id}`)
        .listen('NotificationEvent',(response)=>{
            console.log(response);
            router.reload(['notifications'])

        })
})
</script>

<template>
    <div
        class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="toggleSidebar(true)">
            <span class="sr-only">Open sidebar</span>
            <Bars3Icon class="h-6 w-6" aria-hidden="true"/>
        </button>

        <!-- Separator -->
        <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"/>

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <form class="relative flex flex-1" action="#" method="GET">
                <label for="search-field" class="sr-only">Search</label>
                <MagnifyingGlassIcon
                    class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
                    aria-hidden="true"/>
                <input id="search-field"
                       class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                       placeholder="Search..." type="search" name="search"/>
            </form>
            <div class="flex items-center gap-x-4 lg:gap-x-6">
                <Menu as="div" class="relative">
                    <MenuButton class="-m-1.5 flex items-center p-1.5">
                        <div class="relative">
                            <div v-if="notifications && notifications.length" class="absolute -right-2 -top-1 text-sm text-white bg-red-500  h-5 flex items-center justify-center rounded-full px-1">
                                {{notifications.length}}
                            </div>
                            <i class="bi bi-bell text-slate-400 text-2xl"></i>
                        </div>
                    </MenuButton>
                    <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                        <MenuItems
                            v-if="notifications && notifications.length"
                            class="absolute focus:border-none ring-0 border-none focus:ring-0 right-0 z-10 mt-2.5 w-80 origin-top-right rounded-md bg-white py-2 shadow-lg  ring-gray-900/5 focus:outline-none">
                            <MenuItem  v-for="item in notifications" :key="item.id" v-slot="{ active }">
                                <Link   :href="route('admin.notifications.show',item.id)"
                                      :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 hover:bg-primary-100 text-sm leading-6 text-gray-900']">
                                    <b class="text-primary-400">{{item.title }}</b>
                                    <div class="line-clamp-2 text-slate-600" v-html="item.message"></div>
                                    <hr class="w-full text-slate-200 my-2">
                                </Link>

                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>

                <!-- Profile dropdown -->
                <Menu as="div" class="relative">
                    <MenuButton class="-m-1.5 flex items-center p-1.5">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full bg-gray-50"
                             src="/img/default/default-user.png"
                             alt=""/>
                        <span class="hidden lg:flex lg:items-center">
                              <span class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                                    aria-hidden="true">{{ user.name }}</span>
                              <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                </span>
                    </MenuButton>
                    <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                        <MenuItems
                            class="absolute focus:border-none ring-0 border-none focus:ring-0 right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg  ring-gray-900/5 focus:outline-none">
                            <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                <Link :method="item.method"  :href="item.href"
                                   :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']">{{
                                        item.name
                                    }}</Link>
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
