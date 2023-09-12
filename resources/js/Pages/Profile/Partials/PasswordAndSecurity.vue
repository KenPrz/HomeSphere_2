<script setup>

import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import ButtonLarge from "@/Components/ButtonLarge.vue";
import UpdatePasswordForm from "./UpdatePasswordForm.vue";
import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm.vue";
import LoginAlerts from "./LoginAlerts.vue";
</script>
<template>
    <div class="container flex flex-col">
        <div class="my-4 text-xl font-semibold">
            Password and Security
        </div>
        <div class="section flex flex-col">
            <div class="my-2 text-md font-light">
                Login and Recovery
            </div>
            <div>
                <ButtonLarge @click="openPasswordEditModal" label="Change Password"/>
                <ButtonLarge @click="openTwoFactorAuthModal" label="Two-factor Authentication"/>
            </div>
        </div>
        <div class="section flex flex-col">
            <div class="my-2 text-md font-light">
                Security Check
            </div>
            <div>
                <ButtonLarge @click="openLoginAlertsModal" label="Login Alerts"/>
            </div>
        </div>
        <Modal
            :show="showPasswordEditModal"
            @close="closePasswordEditModal"
        >
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdatePasswordForm class="max-w-xl" />
            </div>
        </Modal>
        <Modal
            :show="showTwoFactorAuthModal"
            @close="closeTwoFactorAuthModal"
        >
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <TwoFactorAuthenticationForm class="max-w-xl" />
            </div>
        </Modal>
        <Modal
            :show="showLoginAlertsModal"
            @close="closeLoginAlertsModal"
        >
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <LoginAlerts class="max-w-xl" />
            </div>
        </Modal>
    </div>
</template>
<script>
const showTwoFactorAuthModal = ref(false);
const showPasswordEditModal = ref(false);
const showLoginAlertsModal = ref(false);

const openTwoFactorAuthModal = () => {
    showTwoFactorAuthModal.value = true;
};
const closeTwoFactorAuthModal = () => {
    showTwoFactorAuthModal.value = false;
};

const openPasswordEditModal = () => {
    showPasswordEditModal.value = true;
};
const closePasswordEditModal = () => {
    showPasswordEditModal.value = false;
};
const openLoginAlertsModal = () => {
    showLoginAlertsModal.value = true;
};
const closeLoginAlertsModal = () => {
    showLoginAlertsModal.value = false;
};
</script>