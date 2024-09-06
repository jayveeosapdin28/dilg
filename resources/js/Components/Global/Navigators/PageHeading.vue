<script setup>
defineProps({
    title: String,
    pages: Array
})
</script>

<template>
    <div>
        <div v-if="pages && pages.length">
            <nav class="hidden sm:flex" aria-label="Breadcrumb">
<!--                <ol role="list" class="flex items-center space-x-4">-->
<!--                    <li v-for="(page,index) in pages" :key="page.name">-->
<!--                        <div class="flex items-center">-->
<!--                            <svg v-if="index > 0" class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">-->
<!--                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />-->
<!--                            </svg>-->
<!--                            <a :href="page.href" :class="{'ml-4': index > 0,'hover:text-primary-600' : page.href}"  class="flex items-center text-sm font-medium text-primary-400 " :aria-current="page.current ? 'page' : undefined">-->
<!--                              {{ page.name }}-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                </ol>-->
            </nav>
        </div>
        <div class="mt-2 md:flex md:items-center md:justify-between ">
            <div class="min-w-0 flex-1">
                <h2 class="text-xl font-semibold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{title}}</h2>
            </div>
            <div>
                <slot name="action"/>
            </div>
        </div>
    </div>
</template>
