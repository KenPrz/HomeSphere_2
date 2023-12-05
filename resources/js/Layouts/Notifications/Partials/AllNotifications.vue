<script setup>
    import NotificationCard from "./NotificationCard.vue";
    import UpdatedNotificationCard from "./UpdatedNotificationCard.vue";
    import { defineEmits } from "vue";
    const emits = defineEmits(["removeFromArray"]);
</script>
<template>
        <div v-if="latestNotification.length > 0">
            <div v-for="notification in latestNotification" :key="notification.id">
                <UpdatedNotificationCard
                    :notification="notification"
                    @removeFromArray="removeFromArray"
                />
            </div>
        </div>
        <div v-for="notification in allNotifications" :key="notification.id">
            <NotificationCard
                :notification="notification"
            />
        </div>
</template>
<script>
export default {
    props: {
        user_id: {
            type: Number,
            required: true,
        },
        latestNotification: {
            type: Array,
            required: null,
        },
        allNotifications: {
            type: Array,
            default: null,
        },
    },
    components: {
        NotificationCard,
    },
    methods: {
        removeFromArray(notificationId){
            this.$emit('removeFromArray', notificationId);
        },
    },
}
</script>