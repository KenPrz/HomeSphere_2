<script setup>
import { defineEmits } from 'vue';
import LeaveHomeDialog from './LeaveHomeDialog.vue';
import DeleteHomeDialog from './DeleteHomeDialog.vue';
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import Modal from '@/Components/Modal.vue';
const emit = defineEmits(['close']);
</script>
<template>
    <v-card-text>
        <div class="mx-3 flex flex-col w-1/2">
            <section>
                <h2 class="text-xl font-semibold mb-2">Home Settings</h2>
                <p class="text-gray-500 mb-2">Manage your home settings here.</p>
            </section>
            <section>
                <button @click="showDialog" v-if="homeData.role == 'owner'"
                    class="flex w-auto my-2 text-white bg-red-500 hover:bg-red-600 transition-colors duration-600 py-2 px-3 rounded-md text-md font-medium">
                    <img class="w-5 me-2" :src="'img-assets/vectors/Delete-white.svg'" alt="">
                    <span>Delete Home</span>
                </button>
                <button @click="showDialog" v-else
                    class="flex w-auto bg-zinc-500 hover:bg-zinc-800 transition-colors duration-600 text-white text-md p-2 rounded-md mb-4">
                    <img class="w-5 me-2" :src="'img-assets/nav-vectors/logout-white.svg'" alt="">
                    <span>Leave Home</span>
                </button>
            </section>
            <section>
                <h2 class="text-xl font-semibold mb-2 mt-2">Alert Notificaions</h2>
                <p class="text-gray-500 mb-2">Recieve motion detected notifications?</p>
                <div class="flex items-centers">
                    <ToggleSwitch v-model="recieveNotifications" />
                    <span class="ms-2 text-md font-semibold mt-1">{{ recieveNotifications ? 'Yes' : 'No' }}</span>
                </div>
            </section>
        </div>
    </v-card-text>
    <Modal maxWidth="sm" :show="homeSettingsDialog" @close="closeDialog">
        <template v-if="homeData.role == 'owner'">
            <DeleteHomeDialog :homeID="homeData.id"/>
        </template>
        <template v-else>
            <LeaveHomeDialog :userData="$page.props.auth" @close="closeDialog"/>
        </template>
    </Modal>
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
            required: true,
        },
    },
    data() {
        return {
            homeSettingsDialog: false,
            recieveNotifications: this.user.receive_motion_alerts,
        }
    },
    methods: {
        close(){
            this.$emit('close');
        },
        showDialog() {
            this.homeSettingsDialog = true;
        },
        closeDialog() {
            this.homeSettingsDialog = false;
        },
        deleteHome(user) {
            this.$inertia.delete(route('home.delete', { user }), {
                onSuccess: () => {
                    close();
                },
            });
        },
    },
    watch: {
        recieveNotifications() {
            this.$inertia.put(route('notification.toggle', {
                receive_motion_alerts: this.recieveNotifications,
            }));
        },
    },
}
</script>