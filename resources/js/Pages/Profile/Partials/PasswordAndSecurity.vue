<script setup>

import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import ButtonLarge from "@/Components/ButtonLarge.vue";
import UpdatePasswordForm from "./UpdatePasswordForm.vue";
import ExtraSecurity from "./ExtraSecurity.vue";
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
                <ButtonLarge @click="openLoginAlertsModal" label="Login Alerts"/>
            </div>
        </div>
        <div class="section flex flex-col">
            <div class="my-2 text-md font-light">
                Deletion
            </div>
            <ButtonLarge @click="openExtraSecurity" label="Account Deletion"/>
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
            :show="showExtraSecurityModal"
            @close="closeExtraSecurityModal"
        >
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <ExtraSecurity/>
            </div>
        </Modal>
        <Modal
            :show="showLoginAlertsModal"
            @close="closeLoginAlertsModal"
        >
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <LoginAlerts :auth="$page.props.auth" class="max-w-xl" />
            </div>
        </Modal>
    </div>
</template>
<script>
const showPasswordEditModal = ref(false);
const showLoginAlertsModal = ref(false);
const showExtraSecurityModal = ref(false);

const openExtraSecurity = () => {
    showExtraSecurityModal.value = true;
};
const closeExtraSecurityModal = () => {
    showExtraSecurityModal.value = false;
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