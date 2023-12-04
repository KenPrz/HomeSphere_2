<script setup>
    import NotificationCard from "./NotificationCard.vue";
</script>
<template>
        <div v-for="notification in unreadNotifications" :key="notification.id">
            <NotificationCard
                :notification="notification"
            />
        </div>
</template>
<script>
export default {
    props: {
        unreadNotifications: {
            type: Array,
            required: true,
        },
    },
    components: {
        NotificationCard,
    },
}
</script>