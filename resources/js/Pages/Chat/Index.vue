<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, useForm, usePage} from "@inertiajs/vue3";
import {computed, nextTick, onMounted, ref} from "vue";
import {useCrud} from "@/Composables/useCrud.js";
import ChatForm from "@/Pages/Chat/ChatForm.vue";
import PageHeading from "@/Components/Global/Navigators/PageHeading.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime"
dayjs.extend(relativeTime)


const chats = computed(() => usePage().props.chats);
const rooms = computed(() => usePage().props.rooms);
const room = computed(() => usePage().props.room);

const {submitForm} = useCrud();

const form = useForm({
    message: null,
    room: room.value?.uuid,
})



const title = 'Chat'
const pages = [
    {name: 'Chat List', href: '#', current: true},
]

const messageContainer = ref(null);
const showChatForm = ref(false)

const scrollToElement = () => {
    const el = messageContainer.value;
    if (el) {
        el.scroll({
            top: el.scrollHeight,
            behavior: 'smooth'
        });
    }
};
onMounted(()=>{
    scrollToElement();
})

const handleSendMessage = () =>{
    axios.post(route('admin.chats.store'),form)
        .then((res)=>{
            form.reset();
            nextTick(()=>{
                scrollToElement();
            })
        })
}

const handleSelectRecipient = (uuid) => {
    router.get(route('admin.chats.show',uuid))
}

onMounted(()=>{
    Echo.private(`chat.${room.value?.id}`)
        .listen('SentMessageEvent',(response)=>{
            chats.value.push(response.chat)
            nextTick(()=>{
                scrollToElement();
            })
        })
})

</script>

<template>
    <Head title="Chat"/>
    <ChatForm
        v-model="showChatForm"
    />
    <AuthenticatedLayout class="flex flex-col gap-y-5 ">
        <PageHeading :title="title" :pages="pages">
            <template #action>
                <div class="space-x-4">
                    <VBtn @click="showChatForm = true" variant="outlined" color="primary">
                        <i class="bi bi-plus mr-1"></i>
                        New Message
                    </VBtn>
                </div>
            </template>
        </PageHeading>
        <div class="h-full grid grid-cols-4 lg:grid-cols-5 mt-8 pb-24 gap-6">
            <div class="bg-white rounded-lg border border-primary-600 shadow-lg  h-full overflow-y-auto py-4 hidden lg:block">
                <template v-if="rooms?.length">
                    <div v-for="item in rooms" @click="handleSelectRecipient(item.uuid)" :class="{'!bg-primary-100 ': room?.uuid === item.uuid}" class="flex py-2 px-4 items-center gap-6 text-slate-400 hover:bg-primary-50 cursor-pointer">
                        <img src="/img/default/default-user.png" class="aspect-square w-10 rounded-full">
                        <div>
                            <p class="mb-0 pb-0 leading-4 font-semibold">
                                {{item.name}}
                            </p>
                            <!--                        <small class="mt-0 pt-0"> {{user.email}}</small>-->
                        </div>
                    </div>
                </template>
                <div v-else  class=" h-full max-h-full overflow-y-auto space-y-8 flex justify-center  items-center text-slate-400 text-lg">
                    Chat room is empty
                </div>
            </div>
            <div class="col-span-4 shadow-lg border  rounded-lg h-full overflow-hidden flex flex-col gap-6 p-6">
                <div v-if="room" ref="messageContainer" class=" h-full max-h-full overflow-y-auto space-y-8">
                    <div v-for="chat in chats" :class="{'justify-end ' : chat.user_id === usePage().props.auth?.user?.id}" class="flex  items-start gap-6 px-4">
                       <div class="flex  items-start gap-6 ">
                           <img  :class="{' order-last' : chat.user_id === usePage().props.auth?.user?.id}" src="/img/default/default-user.png" class=" aspect-square w-8 rounded-full">
                           <div>
                               <div class="py-2 px-4 shadow-lg rounded-lg bg-primary-100 max-w-xl">
                                   {{chat.message}}
                               </div>
                               <div :class="{' text-right' : chat.user_id === usePage().props.auth?.user?.id}" >
                                   <small class="text-slate-400">{{dayjs(chat.created_at).fromNow()}}</small>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
                <div v-else  class=" h-full max-h-full overflow-y-auto space-y-8 flex justify-center  items-center text-slate-400 text-lg">
                    Select chat room
                </div>
                <div v-if="chats?.length" class="flex gap-6 h-16">
                    <VTextField
                        color="primary"
                        variant="outlined"
                        density="comfortable"
                        v-model="form.message"
                        :error-messages="form.errors.message"
                        @update:model-value="form.clearErrors('message')"
                        @keydown.enter="handleSendMessage"
                    />
                    <VBtn @click="handleSendMessage" variant="tonal" color="orange" size="large" class="h-full mt-2">Send</VBtn>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
