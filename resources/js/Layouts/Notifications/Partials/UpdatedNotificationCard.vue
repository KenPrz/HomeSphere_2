<script setup>
import { formatDistanceToNow } from 'date-fns';

const now = new Date();

const calculateTimeDifference = (now) => {
    const createdTime = new Date(now);
    return formatDistanceToNow(createdTime, { addSuffix: true });
};
</script>
<template>
    <div class="container text-md">
        <div @click="markAsRead()"
            class="bg-slate-200 container my-1 px-1 py-1 rounded-md flex justify-right items-center cursor-pointer hover:bg-slate-300 transition-colors duration-200">
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
                    {{ notification.data.notification.user.name }}
                </div>
                <div class="text-xs  text-slate-600">
                    {{ notification.data.notification.body  }}
                </div>
                <div class="text-[10px] text-slate-600"
                >
                    <span>{{ calculateTimeDifference(now) }}</span>
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
            this.$inertia.put(route('notification.read'), {
                notification_id: this.notification.id,
            });
            this.$emit('removeFromArray', this.notification.id);
        },
    }
}
</script>
