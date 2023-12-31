<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UsersTab from "./Partials/UsersTab.vue";
import CodesTab from "./Partials/CodesTab.vue";
import HomeSettingsTab from "./Partials/HomeSettingsTab.vue";
</script>
<template>
    <Head title="Settings" />
    <AuthenticatedLayout
        :notifications="$page.props.notifications"
        :homeData="$page.props.homeData"
    >
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
                <v-card >
                    <v-tabs bg-color="primary" color="secondary" v-model="tab">
                        <v-tab value="user">
                            Users
                        </v-tab>
                        <v-tab value="codes">
                            Codes
                        </v-tab>
                        <v-tab value="Settings">
                            Home Settings
                        </v-tab>
                    </v-tabs>
                    <v-card-text>
                        <v-window v-model="tab">
                            <v-window-item value="user"> 
                                <UsersTab
                                    :homeMembers="homeMembers"
                                />
                            </v-window-item>
                            <v-window-item value="codes"> 
                                <CodesTab/>
                            </v-window-item>
                            <v-window-item value="Settings">
                                <HomeSettingsTab
                                    :user="$page.props.auth.user"
                                    :homeData="$page.props.homeData"
                                />
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
    props: {
        homeData: {
            type: Object,
            required: true
        },
        homeMembers: {
            type: Array,
            required: true
        },
        api_key: {
            type: Object,
            required: true
        },
    },
    data(){
        return {
            tab: null,
            homeChannel: null,
        }
    },
    mounted() {
        this.subscribeToChannel(this.homeData.id);
    },
    unmounted() {
        this.unsubscribeFromChannel(this.homeData.id);
    },
    methods: {
        subscribeToChannel(homeId) {
            // Subscribe to the new channel
            this.homeChannel = window.Echo.private(`home.${homeId}`);
            this.homeChannel.subscribed(() => {
            }).listen('.member_joined', (eventData) => {
                this.homeMembers.push(eventData.new_member[0]);
            })
        },
        unsubscribeFromChannel(homeId) {
            window.Echo.leave(`home.${homeId}`);
        },
        removeMember(canceledMember) {
        this.homeMembers = this.homeMembers.filter(member => {
            return !Object.keys(canceledMember).every(prop => member[prop] === canceledMember[prop]);
        });
    },
    }
}
</script>

