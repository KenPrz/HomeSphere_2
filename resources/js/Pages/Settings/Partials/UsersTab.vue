<script setup>
import UserListTable from './UserListTable.vue';
</script>
<template>
    <div class="mx-3">
        <section>
            <h2 class="text-xl font-semibold mb-2">Users</h2>
            <p class="text-gray-500 mb-2">Manage the users in your home here.</p>
        </section>
    </div>
    <v-container>
        <UserListTable :homeMembers="homeMembers" :headerText="tableHeaders" />
    </v-container>
</template>
<script>
export default {
    props: {
        homeMembers: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        tab: null,
        tableHeaders: [
                {
                    text: "First Name",
                },
                {
                    text: "Last Name",
                },
                {
                    text: "Role",
                },
                {
                    text: "Join Date",
                },
            ],
            maxHeight: "max-h-92",
    }),
}
</script>