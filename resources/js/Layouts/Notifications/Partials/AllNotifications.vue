<script setup>
    import NotificationCard from "./NotificationCard.vue";
</script>
<template>
        <div v-for="notification in allNotifications" :key="notification.id">
            <NotificationCard
                :notification="notification"
            />
        </div>
</template>
<script>
export default {
    props: {
        allNotifications: {
            type: Array,
            required: true,
        },
    },
    components: {
        NotificationCard,
    },
}
</script>