<template>
    <div class="flex w-full items-center justify-center">
        <SecondaryButton @click="toggleModal"> Register </SecondaryButton>
    </div>

    <Modal :show="isModalVisible" @close="closeModal">
        <Register />
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Register from "@/Pages/Auth/Register.vue";

const isModalVisible = ref(false);

const toggleModal = () => {
    isModalVisible.value = !isModalVisible.value;
};

const closeModal = () => {
    isModalVisible.value = false;
};
</script>
