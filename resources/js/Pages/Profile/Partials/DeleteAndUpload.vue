<template>
    <div class="mt-2 flex w-full flex-col items-center px-2">
        <div class="image-buttons flex md:justify-start">
            <!-- Upload Button -->
            <button
                type="button"
                class="mr-2 cursor-pointer rounded-lg border-2 border-gray-600 bg-none px-3 py-1 text-gray-600 hover:bg-gray-700 hover:text-white transition-colors duration-500 ease-in-out"
                @click="openUploadModal"
            >
                Upload
            </button>

            <!-- Delete Button (When Profile Image Exists) -->
            <div v-if="$page.props.auth.user.profile_image">
                <button
                    type="button"
                    class="mr-2 cursor-pointer rounded-lg border-2 border-gray-600 bg-none px-3 py-1 text-gray-600 transition-colors duration-500 ease-in-out hover:bg-red-700 hover:text-white"
                    @click="openDeleteModal"
                >
                    Delete
                </button>
            </div>

            <!-- Delete Button (When Profile Image Doesn't Exist) -->
            <div v-else>
                <button
                    type="button"
                    class="opacity-50 cursor-not-allowed disabled:opacity-50 border-2 border-gray-600 disabled:cursor-not-allowed rounded-lg bg-gray-600 px-3 py-1 text-white transition-colors duration-500 ease-in-out hover:bg-red-700"
                >
                    Delete
                </button>
            </div>
        </div>

        <!-- Upload Modal -->
        <Modal :show="showUploadModal" @close="closeUploadModal">
            <UploadImage />
        </Modal>
        <!-- Delete Modal -->
        <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <DropImage />
        </Modal>
    </div>
</template>

<script setup>
import { ref } from "vue";
import UploadImage from "@/Pages/Profile/Partials/UploadImage.vue";
import DropImage from "@/Pages/Profile/Partials/DropImage.vue";
import Modal from "@/Components/Modal.vue";

const showUploadModal = ref(false);
const showDeleteModal = ref(false);

const openUploadModal = () => {
    showUploadModal.value = true;
};

const closeUploadModal = () => {
    showUploadModal.value = false;
};

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};
</script>
