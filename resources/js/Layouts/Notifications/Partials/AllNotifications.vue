<script setup>
    import NotificationCard from "./NotificationCard.vue";
</script>
<template>
        <div v-for="notification in notifications" :key="notification.id">
            <NotificationCard
                :notification="notification"
            />
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
}
</script>