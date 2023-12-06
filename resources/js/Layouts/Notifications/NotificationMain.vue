<script setup>
import NotificationCard from "./Partials/NotificationCard.vue";
import AllNotifications from "./Partials/AllNotifications.vue";
import UnreadNotifications from "./Partials/UnreadNotifications.vue";
import { defineEmits } from 'vue';

const emits = defineEmits(['removeFromArray', 'clearArray']);
</script>
<template>
    <div class="container flex-col">
        <div class="w-full flex flex-col">
            <div class="wrapper mx-5">
                <div class="text-xl font-semibold text-slate-600 my-2 pt-3">
                    Notifications
                </div>
                <div class="flex mb-2">
                    <button @click="selectAll" 
                        :class="[selected.all == true ? 'bg-slate-500 text-white' : 'bg-slate-200 text-slate-600']"
                        class="p-1 px-3 text-sm font-medium tracking-wide me-2 bg-slate-200 rounded-2xl text-slate-600 hover:text-slate-50 hover:bg-slate-500 transition-colors duration-200">
                        All
                    </button>
                    <button
                        :class="[selected.unread == true ? 'bg-slate-500 text-white' : 'bg-slate-200 text-slate-600']"
                        @click="selectUnread" class="p-1 px-3 text-sm font-medium bg-slate-200 rounded-2xl text-slate-600 hover:text-slate-50 hover:bg-slate-500 transition-colors duration-200">
                        Unread
                    </button>
                </div>
            </div>
            <div v-if="counter > 0" class="w-full flex justify-end">
                <button @click="markAllAsRead" class="me-5 text-xs text-blue-500 hover:text-blue-600 hover:underline transition-all duration-300">
                    mark all as read
                </button>
            </div>
            <div v-else-if="latestNotification.length > 0" class="w-full flex justify-end">
                <button @click="clearArray" class="me-5 text-xs text-blue-500 hover:text-blue-600 hover:underline transition-all duration-300">
                    mark all as read
                </button>
            </div>
        </div>
        <div class="max-h-72 overflow-y-scroll">
            <section class="py-1 px-2
            ">
            <div v-if="selected.all == true">
                <AllNotifications
                    :user_id="user.id"
                    :allNotifications="allNotifications"
                    :latestNotification="latestNotification"
                    @removeFromArray="removeFromArray"
                />
            </div>
            <div v-else>
                <UnreadNotifications
                    :user_id="user.id"
                    :unreadNotifications="unreadNotifications"
                    :latestNotification="latestNotification"
                    @removeFromArray="removeFromArray"
                />
            </div>
            </section>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        user: {
            type: Object,
            required: true,
        },
        notifications: {
            type: Array,
            default: null,
        },
        latestNotification: {
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
        },
        markAllAsRead(){
            if(this.notifications == null) return;
            this.$inertia.patch(route('notification.allRead'), {
                user_id: this.user.id,
            });
        },
        countUnreadNotifications() {
            return this.unreadNotifications.length;
        },
        removeFromArray(notificationId){
            this.$emit('removeFromArray', notificationId);
        },
        clearArray(){
            this.$emit('clearArray');
        },
    },
    computed: {
        allNotifications() {
            return this.notifications;
        },
        unreadNotifications() {
            return this.notifications.filter(notification => notification.notification.read_at === null);
        },
        counter(){
            if(this.notifications == null) return;
            return this.notifications.filter(notification => notification.notification.read_at === null).length
        }
    },
    mounted(){
        if(this.countUnreadNotifications > 0){
            this.selected.all = false;
            this.selected.unread = true;
        }
    }
};
</script>