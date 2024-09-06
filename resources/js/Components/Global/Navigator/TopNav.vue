<script setup>
import DropdownLink from "@/Components/DropdownLink.vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import {ref} from "vue";

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

</script>

<template>
    <nav class="border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                           <img src="/img/logo/dilg_logo.svg" class="w-8 h-8">
                        </Link>
                    </div>

                </div>

                <div class="flex flex-row">
                    <div class="flex flex-row items-center">
                        <span v-if="usePage().props?.role && usePage().props?.role.length" class="bg-green-500 text-sm text-white px-2 rounded-full mr-3">
                            {{ usePage().props?.role[0]}}
                        </span>

                        <button >
                            <i class="bi bi-envelope text-xl text-slate-500 mr-3"></i>
                        </button>
                        <button>
                            <i class="bi bi-bell text-xl text-slate-500 mr-3"></i>
                        </button>
                        <button>
                            <i class="bi bi-gear text-xl text-slate-500 mr-1"></i>
                        </button>
                    </div>

                    <div class="hidden sm:flex sm:items-center ">

                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <Dropdown align="right" width="48">

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>


                                    <div class="border-t border-gray-200"/>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->

                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            @click="showingNavigationDropdown = ! showingNavigationDropdown">
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </nav>
</template>

<style scoped>

</style>
