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
            <div class="w-auto p-6 bg-white rounded-lg shadow-md">
                <h1 class="text-2xl font-semibold mb-4">Upload an Image</h1>
                <form class="w-auto" action="#" method="#" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Select an image:</label>
                        <input type="file" id="image" name="image" accept="image/*" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        Upload
                    </button>
                </form>
            </div>
        </Modal>
        <!-- Delete Modal -->
        <Modal :show="showDeleteModal" @close="closeDeleteModal">
                <div class="bg-white p-8 rounded shadow-md w-full">
                    <h2 class="text-2xl font-semibold mb-4">Confirm Deletion</h2>
                    <p class="mb-4">Are you sure you want to delete this item?</p>
                    <form>
                        <div class="flex justify-end space-x-4">
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                            <button @click="closeDeleteModal" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                        </div>
                    </form>
                </div>
        </Modal>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

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
