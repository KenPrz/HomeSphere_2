<script setup>
import UserListTable from './UserListTable.vue';
</script>
<template>
    <div class="mx-3">
        <h1 class="text-md font-medium">List of Users</h1>
    </div>
    <v-container>
        <UserListTable :homeMembers="$page.props.homeMembers" :headerText="tableHeaders" />
    </v-container>
</template>
<script>
export default {
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