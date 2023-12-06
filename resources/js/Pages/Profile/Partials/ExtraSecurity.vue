<script setup>
    import Modal from '@/Components/Modal.vue';
    import DeleteUserForm from './DeleteUserForm.vue';
</script>
<template>
    <div class="container flex flex-col">
        <div class="my-4 text-xl font-semibold">
            Delete Account
        </div>
        <div class="container flex flex-col items-start">
            <button @click="openDeleteAccount" class="bg-red-500 font-semibold text-white px-4 py-2 w-full text-start rounded-xl hover:bg-red-600 transition-colors duration-200">
                Delete this account
            </button>
        </div>
    </div>
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
            openDeleteAccount() {
                this.showDeleteAccount = true;
            },
            closeDeleteAccount() {
                this.showDeleteAccount = false;
            },
        }
    }
</script>