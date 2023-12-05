<script setup>
    import NotificationCard from "./NotificationCard.vue";
    import UpdatedNotificationCard from "./UpdatedNotificationCard.vue";
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
        <div v-for="notification in unreadNotifications" :key="notification.id">
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
        unreadNotifications: {
            type: Array,
            required: null,
        },
        latestNotification: {
            type: Array,
            required: null,
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