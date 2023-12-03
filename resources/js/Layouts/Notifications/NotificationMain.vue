<script setup>
import NotificationCard from "./Partials/NotificationCard.vue";
import AllNotifications from "./Partials/AllNotifications.vue";
import UnreadNotifications from "./Partials/UnreadNotifications.vue";
</script>
<template>
    <div class="container flex-col">
        <div class="wrapper mx-5">
            <div class="text-xl font-semibold text-slate-600 my-2 pt-3">
                Notifications
            </div>
            <div class="flex mb-2">
                <button @click="selectAll" 
                    :class="[selected.all == true ? 'bg-slate-500 text-slate-50' : 'bg-slate-200 text-slate-600']"
                    class="p-1 px-3 text-sm font-medium tracking-wide me-2 bg-slate-200 rounded-2xl text-slate-600 hover:text-slate-50 hover:bg-slate-500 transition-colors duration-200">
                    All
                </button>
                <button
                    :class="[selected.unread == true ? 'bg-slate-500 text-slate-50' : 'bg-slate-200 text-slate-600']"
                    @click="selectUnread" class="p-1 px-3 text-sm font-medium bg-slate-200 rounded-2xl text-slate-600 hover:text-slate-50 hover:bg-slate-500 transition-colors duration-200">
                    Unread
                </button>
            </div>
        </div>
        
        <div class="mx-1 max-h-72 overflow-y-scroll">
            <section class="py-1 px-2
            ">
            <div v-if="selected.all == true">
                <AllNotifications
                    :notifications="notifications"
                />
            </div>
            <div v-else>
                <UnreadNotifications />
            </div>
            </section>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        notifications: {
            type: Array,
            default: null,
        },
    },
    components: {
        NotificationCard,
    },
    data(){
        return{
            selected: {
                all: true,
                unread: false,
            },
        }
    },
    methods: {
        selectAll(){
            this.selected.all = true;
            this.selected.unread = false;
        },
        selectUnread(){
            this.selected.all = false;
            this.selected.unread = true;
        }
    }
};
</script>