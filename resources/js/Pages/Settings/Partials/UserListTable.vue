<script setup>
import { defineProps, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import UserSettingModal from './UserSettingModal.vue';

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
                    <td class="px-6 py-4">{{ capitalizeFirstLetter(member.firstName) }}</td>
                    <td class="px-6 py-4">{{ capitalizeFirstLetter(member.lastName) }}</td>
                    <td class="px-6 py-4">{{ member.role }}</td>
                    <td class="px-6 py-4">{{ member.joined_on }}</td>
                </tr>
            </template>
            <template v-else>
                <tr v-for="member in $page.props.homeMembers" :key="`non-owner-${member.id}`"
                    class="odd:bg-gray-100 even:bg-white hover:bg-gray-200 cursor-pointer">
                    <td class="px-6 py-4">{{ capitalizeFirstLetter(member.firstName) }}</td>
                    <td class="px-6 py-4">{{ capitalizeFirstLetter(member.lastName) }}</td>
                    <td class="px-6 py-4">{{ member.role }}</td>
                    <td class="px-6 py-4" v-if="member.joined_on==null || !member.joined_on">----------</td>
                    <td class="px-6 py-4" v-else>{{ member.joined_on }}</td>
                </tr>
            </template>
        </tbody>

    </table>
    <Modal maxWidth="sm" :show="showUserSetting" @close="hideUserSettingModal">
            <UserSettingModal :userData="member" @close="hideUserSettingModal"/>
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
        capitalizeFirstLetter(str) {
            if (!str) return "";
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
    },
}
</script>
