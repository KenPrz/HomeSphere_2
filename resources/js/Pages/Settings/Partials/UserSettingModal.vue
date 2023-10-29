<script setup>
defineProps({
    userData: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <div class="user-approval-card">
        <div class="user-details">
            <p><strong>Name:</strong> {{ userData.firstName }} {{ userData.lastName }}</p>
            <p><strong>Role:</strong> {{ userData.role }}</p>
            <p><strong>Joined On:</strong> {{ userData.joined_on }}</p>
        </div>
        <div class="approval-button">
            <!-- <button @click="approveUser">Approve</button> -->
        </div>
    </div>
</template>
