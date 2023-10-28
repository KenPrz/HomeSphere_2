<script setup>
import { Head } from "@inertiajs/vue3";
import UserListTable from "./Partials/UserListTable.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
<template>
    <Head title="Settings" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 space-y-6 leading-tight">
                Settings
            </h2>
        </template>
        <main>
            <div class="container">
                <h1 class="text-3xl mb-2 font-bold tracking-wide">
                    Settings
                </h1>
                <v-card>
                    <v-tabs v-model="tab" class="custom-tabs">
                        <v-tab value="user">Users</v-tab>
                        <v-tab value="codes">Codes</v-tab>
                        <v-tab value="delete">Delete Home</v-tab>
                    </v-tabs>
                    <v-card-text>
                        <v-window v-model="tab">
                            <v-window-item value="user"> 
                                <div class="mx-3">
                                    <h1 class="text-md font-medium">List of Users</h1>
                                </div>
                                <v-container>
                                    <UserListTable
                                        :tableHeaders="tableHeaders"
                                        :tableData="$page.props.homeMembers"
                                        :maxHeight="maxHeight"
                                        :itemsPerPage="7"
                                        :Pagenated="true"
                                    />
                                </v-container>
                            </v-window-item>

                            <v-window-item value="codes"> 
                                <div class="mx-3">
                                    <h1 class="text-md font-medium">Home Codes</h1>
                                </div>
                                <v-container>
                                    <v-card>
                                        {{ "Invite Code:" + $page.props.homeData.invite_code }}
                                    </v-card>
                                    <v-card>
                                        {{ "API Key:" + $page.props.api_key.api_key }}
                                    </v-card>
                                </v-container>
                            </v-window-item>

                            <v-window-item value="delete"> 
                                <div class="mx-3">
                                    <h1 class="text-md font-medium text-red-600">
                                        Delete Home
                                    </h1>
                                </div>
                            </v-window-item>
                        </v-window>
                    </v-card-text>
                </v-card>
            </div>
        </main>
    </AuthenticatedLayout>
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
<style scoped>
.custom-tabs {
    background-color: white;
}

.custom-tabs v-tab {
    color: white;
}
</style>
