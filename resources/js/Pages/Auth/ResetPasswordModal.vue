<template>
    <div class="flex w-full items-center justify-end">
        <a class="text-xs hover:text-blue-600 cursor-pointer" @click="toggleModal"> Forgot Password? </a>
    </div>
    <Modal :show="isModalVisible" @close="closeModal">
        <div class="p-10">
            <ForgotPassword/>
        </div>
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import ForgotPassword from "@/Pages/Auth/ForgotPassword.vue";

const isModalVisible = ref(false);

const toggleModal = () => {
    isModalVisible.value = !isModalVisible.value;
};

const closeModal = () => {
    isModalVisible.value = false;
};
</script>
