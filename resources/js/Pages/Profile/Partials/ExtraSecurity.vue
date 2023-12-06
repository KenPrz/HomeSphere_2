<script setup>
    import Modal from '@/Components/Modal.vue';
    import DeleteUserForm from './DeleteUserForm.vue';
</script>
<template>
    <div class="container flex flex-col">
        <div class="my-4 text-xl font-semibold">
            Add extra security to your account
        </div>
        <div class="container flex flex-col items-start">
            <button @click="openCloseAllSessions" class="bg-blue-500 font-semibold text-white px-4 py-2 w-full text-start rounded-xl hover:bg-blue-600 transition-colors duration-200 mb-2">
                Logout all sessions
            </button>
            <button @click="openDeleteAccount" class="bg-red-500 font-semibold text-white px-4 py-2 w-full text-start rounded-xl hover:bg-red-600 transition-colors duration-200">
                Delete this account
            </button>
        </div>
    </div>
    <Modal :show="showCloseAllSessions" @close="closeCloseAllSessions">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="text-xl font-semibold mb-4">
                Logout all sessions?
            </div>
            <div class="mb-4">
                Are you sure you want to logout all sessions?
            </div>
            <div class="flex">
                <button @click="closeCloseAllSessions"
                    class="flex-1 text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-4 hover:bg-gray-400 transition duration-300">
                    No, cancel
                </button>
                <button @click="closeCloseAllSessions"
                    class="flex-1 text-sm bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                    Yes, logout all sessions
                </button>
            </div>
        </div>
    </Modal>
    <Modal :show="showDeleteAccount" @close="closeDeleteAccount">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <DeleteUserForm class="max-w-xl" />
        </div>
    </Modal>
</template>
<script>
    export default {
        components: {
            Modal,
        },
        data() {
            return {
                showCloseAllSessions: false,
                showDeleteAccount: false,
            }
        },
        methods: {
            openCloseAllSessions() {
                this.showCloseAllSessions = true;
            },
            closeCloseAllSessions() {
                this.showCloseAllSessions = false;
            },
            openDeleteAccount() {
                this.showDeleteAccount = true;
            },
            closeDeleteAccount() {
                this.showDeleteAccount = false;
            },
        }
    }
</script>