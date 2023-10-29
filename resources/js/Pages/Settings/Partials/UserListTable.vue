<script setup>
import { defineProps, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import UserSettingModal from './UserSettingModal.vue';
import { router } from '@inertiajs/vue3'
defineProps({
    homeMembers: {
        type: Array,
        required: true,
    },
    headerText: {
        type: Array,
        required: true,
    }
});
</script>
<template>
    <table class="min-w-full">
        <thead>
            <tr>
                <th v-for="item in headerText" class="px-6 py-3 text-left">{{ item.text }}</th>
            </tr>
        </thead>
        <tbody>
            <template v-if="$page.props.homeData.role == 'owner'">
                <tr @click="showUserSettingModal(member)" v-for="member in $page.props.homeMembers"
                    :key="`owner-${member.id}`" class="odd:bg-gray-100 even:bg-white hover:bg-gray-200 cursor-pointer">
                    <td class="px-6 py-4">{{ member.firstName }}</td>
                    <td class="px-6 py-4">{{ member.lastName }}</td>
                    <td class="px-6 py-4">{{ member.role }}</td>
                    <td class="px-6 py-4">{{ member.joined_on }}</td>
                </tr>
            </template>
            <template v-else>
                <tr v-for="member in $page.props.homeMembers" :key="`non-owner-${member.id}`"
                    class="odd:bg-gray-100 even:bg-white hover:bg-gray-200 cursor-pointer">
                    <td class="px-6 py-4">{{ member.firstName }}</td>
                    <td class="px-6 py-4">{{ member.lastName }}</td>
                    <td class="px-6 py-4">{{ member.role }}</td>
                    <td class="px-6 py-4">{{ member.joined_on }}</td>
                </tr>
            </template>
        </tbody>

    </table>
    <Modal maxWidth="sm" :show="showUserSetting" @close="hideUserSettingModal">
        <div v-if="member.role == 'member' || member.role == 'owner'">
            <UserSettingModal :userData="member" />
        </div>
        <div v-else-if="member.role == 'pending'">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Approve User Membership Request?</h2>
                <p class="text-gray-600 mb-4 text-md">Do you want to approve this user's request to become a member?</p>
                <div class="flex justify-end">
                    <button @click="approveUser(member)"
                        class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-4 hover:bg-gray-400 transition duration-300">
                        Yes, approve
                    </button>
                    <button @click="rejectUser(member)"
                        class="flex-1 bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                        No, Reject
                    </button>
                </div>
            </div>
        </div>
    </Modal>
</template>
<script>

export default {
    data() {
        return {
            user: null,
            showUserSetting: false,
        };
    },
    methods: {
        showUserSettingModal(row) {
            this.member = row;
            this.showUserSetting = true;
        },
        hideUserSettingModal() {
            this.showUserSetting = false;
        },
        approveUser(member) {
            this.$inertia.post(route('member.approve', {member}), {
                onSuccess: () => {
                    this.hideUserSettingModal();
                    router.go(0);
                }
            });
            this.hideUserSettingModal();
        },
        rejectUser(member) {
            this.$inertia.post(route('member.reject', {member}), {
                onSuccess: () => {
                    this.hideUserSettingModal();
                    router.go(0);
                }
            });
        }
    },
}
</script>
