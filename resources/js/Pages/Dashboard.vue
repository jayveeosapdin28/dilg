<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage, Link} from '@inertiajs/vue3';
import {computed} from "vue";
import { ArrowDownIcon, ArrowUpIcon } from '@heroicons/vue/20/solid'


const data = computed(()=>usePage().props.data)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div v-for="item in data" :key="item.id" class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute aspect-square rounded-md bg-primary-500 p-3">
                        <i  class="h-10 w-10 text-white text-xl" :class="item.icon" aria-hidden="true" />
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ item.name }}</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">{{ item.stat }}</p>
                    <p v-if="item.change !== 0" :class="[item.changeType === 'increase' ? 'text-green-600' : 'text-red-600', 'ml-2 flex items-baseline text-sm font-semibold']">
                        <ArrowUpIcon v-if="item.changeType === 'increase'" class="h-5 w-5 flex-shrink-0 self-center text-green-500" aria-hidden="true" />
                        <ArrowDownIcon v-else class="h-5 w-5 flex-shrink-0 self-center text-red-500" aria-hidden="true" />
                        <span class="sr-only"> {{ item.changeType === 'increase' ? 'Increased' : 'Decreased' }} by </span>
                        {{ item.change }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <Link :href="item.link" class="font-medium text-primary-600 hover:text-primary-500">
                                View all<span class="sr-only"> {{ item.name }} stats</span></Link>
                        </div>
                    </div>
                </dd>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
