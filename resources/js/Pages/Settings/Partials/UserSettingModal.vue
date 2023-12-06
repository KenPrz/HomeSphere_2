<script setup>
import Modal from '@/Components/Modal.vue';
import ApprovalModal from './ApprovalModal.vue';
import KickUserDialog from './KickUserDialog.vue';
import PromoteUserDialog from './PromoteUserDialog.vue';
import DemoteUserDialog from './DemoteUserDialog.vue';
import { defineEmits } from 'vue';
import { formatDistanceToNow } from 'date-fns';
const emit = defineEmits(["close"]);
const calculateTimeDifference = (createdAt) => {
    const createdTime = new Date(createdAt);
    return formatDistanceToNow(createdTime, { addSuffix: true });
};
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
                <div v-if="userData.email_verified_at == null">
                    <p class="text-red-500 text-sm">This user is not verified</p>
                </div>
                <div v-else class="text-sm">
                    <p>Verified: {{ calculateTimeDifference(userData.email_verified_at) }}</p>
                </div>
                </div>
                <div v-if="userData.role == 'member' || userData.role == 'admin' || userData.role == 'owner'">
                    <p class="text-center text-gray-600 text-xs">Joined: {{ userData.joined_on }}</p>
                    <button v-if="userData.role == 'member'" @click="openUserPromotionModal(userData)" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mt-2 transition duration-300">
                        Promote User
                    </button>
                    <div v-if="userData.role == 'admin'">
                        <button v-if="userData.role == 'admin' && userData.id != $page.props.auth.user.id" @click="openUserDemotionDialog(userData)" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mt-2 transition duration-300">
                            Demote User
                        </button>
                        <button v-else-if="userData.role == 'admin' && userData.id == $page.props.auth.user.id" @click="openUserDemotionDialog(userData)" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg mt-2 transition duration-300">
                            Demote Myself
                        </button>
                    </div>
                    <button v-if="userData.role == 'member'" @click="openUserKickDialog(userData)" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg mt-2 transition duration-300">
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
        <Modal :maxWidth="'sm'" :show="showUserPromotion" @close="closeUserApprovalModal">
            <PromoteUserDialog :userData="userData" @close="closeUserPromotionModal"/>
        </Modal>
        <Modal :maxWidth="'sm'" :show="showUserDemotionDialog" @close="closeUserDemotionDialog">
            <DemoteUserDialog :userData="userData" @close="closeUserDemotionDialog"/>
        </Modal>
    </div>
</template>
<script>
export default {
    data() {
        return {
            showUserApproval: false,
            showUserKickDialog:false,
            showUserPromotion: false,
            showUserDemotionDialog:false,
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
        openUserPromotionModal(userData) {
            this.user = userData;
            this.showUserPromotion = true;
        },
        openUserDemotionDialog(userData){
            this.user = userData;
            this.showUserDemotionDialog = true;
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
        closeUserPromotionModal() {
            this.close();
        },
        closeUserDemotionDialog(){
            this.close();
        }
    },
};
</script>
