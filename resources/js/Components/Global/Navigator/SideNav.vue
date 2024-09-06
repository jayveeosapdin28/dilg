<script setup>
import {Link} from "@inertiajs/vue3";
import {useRole} from "@/Composables/useRole.js";

const links = [
    {
        label: 'Dashboard',
        icon: 'bi bi-columns-gap',
        route: 'dashboard',
        base_route: 'dashboard',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Document',
        icon: 'bi bi-files',
        route: 'admin.documents.index',
        base_route: 'admin.documents.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Task',
        icon: 'bi bi-card-checklist',
        route: 'admin.tasks.index',
        base_route: 'admin.tasks.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Case',
        icon: 'bi bi-folder2',
        route: 'admin.cases.index',
        base_route: 'admin.cases.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Event',
        icon: 'bi bi-calendar2-week',
        route: 'admin.events.index',
        base_route: 'admin.events.*',
        access: ['Admin', 'Super Admin', 'User']
    },
    {
        label: 'Rank',
        icon: 'bi bi-trophy',
        route: 'admin.ranks.index',
        base_route: 'admin.ranks.*',
        access: ['Admin', 'Super Admin']
    },
    {
        label: 'Users',
        icon: 'bi bi-people',
        route: 'admin.users.index',
        base_route: 'admin.users.*',
        access: [ 'Super Admin']
    },
];

const {isInRole} = useRole();

</script>

<template>
    <div class=" w-[13rem] rounded-lg hidden sm:block   overflow-y-auto max-h-[calc(100vh-6.5rem)] mt-8">
        <ul class="h-full">
            <template v-for="link in links">
                <li
                    class="mb-2 cursor-pointer   hover:font-semibold p-2 px-4 rounded-lg"
                    :class="{'bg-primary-100 font-semibold': route().current(link.base_route)}"
                >
                    <Link :href="route(link.route)" class="flex gap-4 hover:text-primary-500"
                          :class="route().current(link.base_route) ? 'text-primary-500' : 'text-slate-500 '">
                        <i :class="link.icon"></i>
                        {{ link.label }}
                    </Link>
                </li>
            </template>
        </ul>
    </div>
</template>

<style scoped>

</style>
