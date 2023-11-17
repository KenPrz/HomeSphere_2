<script setup>
import Modal from '@/Components/Modal.vue';
import ApprovalModal from './ApprovalModal.vue';
import KickUserDialog from './KickUserDialog.vue';
import { defineEmits } from 'vue';

const emit = defineEmits(["close"]);

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
            <div class="w-full mx-auto p-4 bg-white shadow-lg rounded-lg">
                <!-- <button @click="close" class="bg-red-500 hover:bg-red-600 p-2 rounded-md text-white">TestEmit</button> -->
                <div class="text-center">
                    <v-img v-if="userData.profile_image" class="rounded-md mx-auto" width="130" :aspect-ratio="1"
                        :src="'storage/' + userData.profile_image" cover></v-img>
                    <v-img v-else class="rounded-md mx-auto" width="130" :aspect-ratio="1"
                        src="/img-assets/default_avatar.png" cover></v-img>
                    <h2 class="text-xl font-semibold mt-4">{{ capitalizeFirstLetter(userData.firstName) + ' ' +
                        capitalizeFirstLetter(userData.lastName) }}</h2>
                    <p class="text-gray-500 text-sm">{{ capitalizeFirstLetter(userData.role) }}</p>
                </div>
                <div v-if="userData.role == 'member' || userData.role == 'owner'">
                    <p class="text-center text-gray-600 text-xs">Joined: {{ userData.joined_on }}</p>
                    <button @click="openUserKickDialog(userData)" v-if="userData.role == 'member'" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg mt-2 transition duration-300">
                        Kick User
                    </button>
                </div>
                <div v-else>
                    <ApprovalModal :userData="userData" @close="closeUserApprovalModal"/>
                </div>
            </div>
        </div>
    </div>
    <div>
        <Modal :maxWidth="'sm'" :show="showUserKickDialog" @close="closeUserKickDialog">
            <KickUserDialog :userData="userData" @close="closeUserKickDialog"/>
        </Modal>
    </div>
</template>
<script>
export default {
    data() {
        return {
            showUserApproval: false,
            showUserKickDialog:false,
        };
    },
    methods: {
        capitalizeFirstLetter(str) {
            if (!str) return "";
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        close() {
            this.$emit('close');
        },
        openUserKickDialog(userData){
            this.user = userData;
            this.showUserKickDialog = true;
        },
        openUserApprovalModal(userData) {
            this.user = userData;
            this.showUserApproval = true;
        },
        closeUserKickDialog(){
            this.close();
        },
        closeUserApprovalModal() {
            this.close();
        },
    },
};
</script>
