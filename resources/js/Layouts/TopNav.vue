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
        <div class="mx-auto md:px-6 lg:px-8">
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
                <div v-if="$page.props.auth.user" class="flex items-center ml-6">
                    <!-- Settings Dropdown -->
                    <div class="w-full relative flex items-center ">
                        <Dropdown align="right" :width="'64'">
                            <template #trigger>
                                <div class="relative transition duration-200 hover:scale-95 cursor-pointer">
                                    <img class="h-9 p-2 rounded-full w-auto bg-slate-500 mr-2"
                                    :src="'/img-assets/nav-vectors/notification.svg'" alt="" />
                                    <div v-if="countNullReadAt > 0" class="absolute top-6 left-6 me-2 flex items-center justify-center border bg-red-500 text-white rounded-full w-[15px] h-[15px]">
                                        <span class="text-xs font-light">{{ countNullReadAt + latestNotification.length }}</span>
                                    </div>
                                    <div v-else-if="latestNotification.length > 0" class="absolute top-6 left-6 me-2 flex items-center justify-center border bg-red-500 text-white rounded-full w-[15px] h-[15px]">
                                        <span class="text-xs font-light">{{ latestNotification.length }}</span>
                                    </div>
                                </div>
                            </template>
                            <template #content>
                                <NotificationMain
                                    :notifications="notifications"
                                    :latestNotification="latestNotification"
                                    :user="user"
                                    @clearArray="clearArray"
                                    @removeFromArray="removeFromArray"
                                />
                            </template>
                        </Dropdown>
                        <Dropdown class="hidden md:block" align="right" :width="'64'">
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
        <Modal @close="closeMotionModal()" :hasClose="false" :show="showMotionModal" :maxWidth="'md'">
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
                <div class="flex justify-end">
                    <button @click="muteNotification" class="text-xs text-blue-500 hover:underline rounded-lg">Mute this notification.</button>
                </div>
            </div>
        </Modal>
        <Modal @close="closeGasModal()" :hasClose="false" :show="showGasModal" :maxWidth="'md'">
            <div class="flex flex-col px-5 py-3 bg-blue-100">
                <div class="flex">
                    <div>
                        <v-img class="rounded-md mx-auto" width="75" :aspect-ratio="1"
                            src="img-assets/vectors/info_icon.svg" cover></v-img>
                    </div>
                    <div class="flex items-center justify-center text-xl font-semibold w-full">
                        <span class="text">
                            High Gas Levels in {{ gasLevelsRoomName.data }}!!
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
        user: {
            type: Object,
            required: true,
        },
        homeData: {
            type: Object,
            default: null,
        },
        notifications: {
            type: Array,
            default: null,
        },
    },

    data() {
        return {
            homeChannel: null,
            motionDetectedRoomName: { data: null },
            gasLevelsRoomName: { data: null },
            showMotionModal: false,
            showGasModal: false,
            latestNotification: [],
        };
    },
    mounted() {
        this.subToUserChannel(this.user)
        if (this.homeData) {
            if (this.homeData.role == 'owner' || this.homeData.role == 'member' || this.homeData.role == 'admin') {
                this.subscribeToHomeChannel(this.homeData.id);
            }
        }
    },
    unmounted() {
        this.unsubscribeFromUserChannel(this.user)
        if (this.homeData) {
            this.unsubscribeFromHomeChannel(this.homeData.id);
        }
    },
    methods: {
        subscribeToHomeChannel(homeId) {
            // Subscribe to the new channel
            this.homeChannel = window.Echo.private(`home.${homeId}`);
            this.homeChannel.subscribed(() => {
            }).listen('.motion_detected', (eventData) => {
                this.motionDetectedRoomName.data = eventData.room_name[0];
                if (eventData.motion_detected == true) {
                    if(this.user.receive_motion_alerts == 1){
                        if(this.showMotionModal == false){
                            this.playMotionSound();
                            this.showMotionModal = true;
                        }
                    }
                }
            }).listen('.gas_levels',(eventData)=>{
                this.gasLevelsRoomName.data = eventData.room_name[0];
                if(eventData.gas_levels == true){
                    if(this.showGasModal == false){
                        this.playGasSound();
                        this.showGasModal = true;
                    }
                }
            })
        },
        subToUserChannel(user){
            this.userChannel = window.Echo.private(`App.Models.User.${user.id}`);
            this.userChannel.subscribed(()=>{
                console.log('subscribed to user channel');
            }).listen('.user_accepted', (eventData) => {
                if(eventData.is_accepted==true){
                    console.log(eventData);
                    this.refreshPage();
                }
            }).listen('.user_kicked', (eventData) => {
                this.refreshPage();
            }).listen('.user_demoted', (eventData) => {
                this.refreshPage();
            }).listen('.user_promoted', (eventData) => {
                this.refreshPage();
            }).notification((notification) => {
                this.latestNotification.unshift(notification);
            });
        },
        unsubscribeFromHomeChannel(homeId) {
            window.Echo.leave(`home.${homeId}`);
        },
        unsubscribeFromUserChannel(user) {
            window.Echo.leave(`user.${user.id}`);
        },
        refreshPage() {
            window.location.reload();
        },
        playMotionSound(){
            const audio = new Audio('./notification.mp3');
            audio.play();
        },
        playGasSound(){
            const audio = new Audio('./gas_levels_warning.mp3');
            audio.play();
        },
        closeMotionModal() {
            this.showMotionModal = false;
        },
        closeGasModal() {
            this.showGasModal = false;
        },
        clearArray() {
            const notificationIds = this.latestNotification.map(item => item.id);
            if (notificationIds.length > 0) {
                this.$inertia.put(route('notification.bulkRead'), {
                    notification_ids: notificationIds,
                });
            }
            this.latestNotification = [];
        },
        removeFromArray(notificationId) {
            this.latestNotification = this.latestNotification.filter(item => item.id !== notificationId);
        },
        muteNotification() {
            this.$inertia.put(route('notification.toggle', {
                receive_motion_alerts: !this.user.receive_motion_alerts,
            }));
            this.close();
        },
    },
    computed: {
        countNullReadAt() {
            if (this.notifications == null) {
                return 0;
            }else if(this.notifications.length == 0){
                return 0;
            }else if(this.notifications.length > 0){
                const nullReadAtNotifications = this.notifications.filter(
                    (notification) => notification.notification.read_at === null
                );
                return nullReadAtNotifications.length;
            }
        },
    }
};
</script>