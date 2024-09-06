<script setup>
import {ref} from 'vue'
import Sidebar from "@/Components/Global/Navigators/Sidebar.vue";
import TopBar from "@/Components/Global/Navigators/TopBar.vue";
import MobileSidebar from "@/Components/Global/Navigators/MobileSidebar.vue";
import ConfirmMessage from "@/Components/Common/Message/ConfirmMessage.vue";

const sidebarOpen = ref(false)

</script>


<template>
    <div>
        <MobileSidebar @toggle:sidebar-open="sidebarOpen = $event" :sidebar-open="sidebarOpen"/>
        <div style="z-index: 10" class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <Sidebar/>
        </div>
        <div class="lg:pl-72 flex flex-col h-screen  overflow-hidden bg-gray-50">
            <TopBar @toggle:sidebar-open="sidebarOpen = $event"/>
            <main class="overflow-hidden h-full mb-2">
                <div class="p-4 sm:p-6 lg:p-8 lg:pb-0 h-full  pb-44">
                    <slot/>
                </div>
            </main>
        </div>
    </div>
  <ConfirmMessage/>
</template>
