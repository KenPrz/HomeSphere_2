<script setup>
import Modal from "@/Components/Modal.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NotificationMain from "@/Layouts/Notifications/NotificationMain.vue";
import NavbarProfile from "@/Layouts/partials/NavbarProfile.vue";
</script>

<template>
    <nav class="px-10 bg-white border-b shadow-sm border-gray-100 sticky top-0 z-50">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <a :href="route('dashboard')"
                        class="text-md font-semibold md:text-center text-center flex items-center hover:text-blue-500 transition-colors">
                        <img class="h-10 w-10 rounded-full p-1 mr-2 hover:scale-110 transition-transform"
                            :src="'/img-assets/favicons/android-chrome-512x512.png'" />
                        <h1 class="ml-3">HomeSphere</h1>
                    </a>
                </div>
                <div v-if="$page.props.auth.user" class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="w-full relative flex items-center ">
                        <Dropdown align="right" :width="'64'">
                            <template #trigger>
                                <img class="h-9 p-2 rounded-full w-auto bg-slate-500 mr-2 transition duration-200 hover:scale-95 cursor-pointer"
                                    :src="'/img-assets/nav-vectors/notification.svg'" alt="" />
                            </template>
                            <template #content>
                                <NotificationMain />
                            </template>
                        </Dropdown>
                        <Dropdown align="right" :width="'64'">
                            <template #trigger>
                                <v-img v-if="$page.props.auth.user.profile_image"
                                    class="rounded-full mx-auto transition duration-200 hover:scale-95 cursor-pointer"
                                    width="38" :aspect-ratio="1" :src="'storage/' + $page.props.auth.user.profile_image"
                                    cover></v-img>
                                <v-img v-else
                                    class="rounded-full mx-auto transition duration-200 hover:scale-95 cursor-pointer"
                                    width="38" :aspect-ratio="1" src="/img-assets/default_avatar.png" cover>
                                </v-img>
                            </template>
                            <template #content>
                                <div>
                                    <DropdownLink :href="route('profile.edit')">
                                        <NavbarProfile />
                                    </DropdownLink>
                                </div>
                                <DropdownLink v-if="$page.props.auth.user.has_home === 1" :href="route('settings.index')"
                                    method="get" as="button" class="transition duration-500">
                                    <div class="flex items-center">
                                        <img class="h-6 w-auto me-2" :src="'img-assets/nav-vectors/settings_navbar.svg'"
                                            alt="">
                                        <h1>Settings</h1>
                                    </div>

                                </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button"
                                    class="transition duration-500 hover:text-red-500">
                                    <div class="flex items-center">
                                        <img class="h-6 w-auto me-2" :src="'img-assets/nav-vectors/logout_navbar.svg'"
                                            alt="">
                                        <h1>Logout</h1>
                                    </div>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div>
        <Modal @close="close()" :hasClose="false" :show="showModal" :maxWidth="'md'">
            <div class="flex flex-col px-5 py-3 bg-blue-100">
                <div class="flex">
                    <div>
                        <v-img class="rounded-md mx-auto" width="75" :aspect-ratio="1"
                            src="img-assets/vectors/info_icon.svg" cover></v-img>
                    </div>
                    <div class="flex items-center justify-center text-xl font-semibold w-full">
                        <span class="text">
                            Motion Detected in {{ motionDetectedRoomName.data }}
                        </span>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>
<script>
export default {
    props: {
        homeData: {
            type: Object,
            default: null,
        },
    },

    data() {
        return {
            homeChannel: null,
            motionDetectedRoomName: { data: null },
            showModal: false,
        };
    },
    mounted() {
        if (this.homeData) {
            if (this.homeData.role == 'owner' || this.homeData.role == 'member') {
                this.subscribeToRoomChannel(this.homeData.id);
            }
        }
    },
    unmounted() {
        if (this.homeData) {
            this.unsubscribeFromRoomChannel(this.homeData.id);
        }
    },
    methods: {
        subscribeToRoomChannel(homeId) {
            // Subscribe to the new channel
            this.homeChannel = window.Echo.private(`home.${homeId}`);
            this.homeChannel.subscribed(() => {
            }).listen('.motion_detected', (eventData) => {
                this.motionDetectedRoomName.data = eventData.room_name[0];
                if (eventData.motion_detected == true) {
                    this.showModal = true;
                }
            });
        },
        unsubscribeFromRoomChannel(homeId) {
            window.Echo.leave(`home.${homeId}`);
        },
        close() {
            this.showModal = false;
        },
    },
};
</script>