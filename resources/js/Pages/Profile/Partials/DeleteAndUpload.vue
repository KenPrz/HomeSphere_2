<template>
    <div class="mt-2 flex w-full flex-col items-center px-2">
        <div class="image-buttons flex md:justify-start">
            <button
                type="button"
                class="mr-2 cursor-pointer rounded-lg border-2 border-gray-600 bg-none px-3 py-1 text-gray-600 hover:bg-gray-200 hover:text-gray-800"
                @click="openUploadModal"
            >
                Upload
            </button>
            <button
                type="button"
                class="opacity-50 cursor-not-allowed disabled:opacity-50 disabled:cursor-not-allowed @endif cursor-pointer rounded-lg bg-gray-600 px-3 py-1 text-white transition-colors duration-500 ease-in-out hover:bg-red-700"
                @click="openDeleteModal"
            >
                Delete
            </button>
        </div>

        <!-- Upload Modal -->
        <Modal :show="showUploadModal" @close="closeUploadModal">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <UploadImage />
            </div>
        </Modal>
        <!-- Delete Modal -->
        <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <!-- <div class="p-6 bg-white rounded-lg shadow-md">
                <DeleteImage />
            </div> -->
        </Modal>
    </div>
</template>

<script setup>
import { ref } from "vue";
import UploadImage from "@/Pages/Profile/Partials/UploadImage.vue";
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
