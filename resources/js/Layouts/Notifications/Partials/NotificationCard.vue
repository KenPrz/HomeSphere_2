<script setup>
import { formatDistanceToNow } from 'date-fns';

const calculateTimeDifference = (createdAt) => {
    const createdTime = new Date(createdAt);
    return formatDistanceToNow(createdTime, { addSuffix: true });
};
</script>
<template>
    <div class="container text-md">
        <div @click="markAsRead()"
            :class="[notification.notification.read_at !== null ? 'text-slate-600' : 'bg-slate-200']"
            class="container my-1 px-1 py-1 rounded-md flex justify-left items-center cursor-pointer hover:bg-slate-300 transition-colors duration-200">
            <div class="flex item-center ms-2 me-1">
                <div v-if="notification.user_details">
                    <v-img v-if="notification.user_details.photo"
                        class="rounded-full mx-auto"
                        width="60"
                        :aspect-ratio="1"
                        :src="'storage/'+notification.user_details.photo"
                        cover
                    ></v-img>
                    <v-img v-else
                        class="rounded-full mx-auto"
                        width="60"
                        :aspect-ratio="1"
                        src="/img-assets/default_avatar.png"
                        cover
                    >
                    </v-img>
                </div>
                <div v-else>
                    <v-img
                        class="rounded-full mx-auto p-1"
                        width="60"
                        :aspect-ratio="1"
                        src="/img-assets/System-Icon.png"
                        cover
                    >
                    </v-img>
                </div>       
            </div>
            <div class="mx-1 flex flex-col items-start">
                <div
                    class="text-sm font-semibold text-slate-600">
                    <span v-if="notification.user_details">{{ notification.user_details.name }}</span>
                    <span v-else>System</span>
                </div>
                <div class="text-xs  text-slate-600">
                    {{ notification.notification.data.body  }}
                </div>
                <div class="text-[10px] text-slate-600"
                >
                    <span>{{ calculateTimeDifference(notification.timestamps.created_at) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        notification: {
            object: Object,
            required: true,
        },
    },
    methods: {
        markAsRead(){
            if(this.notification.notification.read_at !== null) return;
            this.$inertia.put(route('notification.read'), {
                notification_id: this.notification.notification.id,
            });
        }
    }
}
</script>
