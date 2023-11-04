<script setup>
import Modal from '@/Components/Modal.vue';
</script>
<template>
    <div class="bg-gray-200 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 shadow-md w-full sm:w-96">
            <div class="text-lg font-semibold text-gray-800 mb-4">
                Are you sure you want to delete this home?
            </div>
            <div class="flex justify-center">
                <button @click="deleteHome($page.props.auth.user.id)"
                    class="bg-red-500 hover:bg-red-600 transition-colors duration-200 text-white px-4 py-2 rounded-lg font-semibold w-28 me-4">
                    Yes
                </button>
                <button @click="close"
                    class="bg-gray-300 hover:bg-gray-400 transition-colors duration-200 text-gray-700 px-4 py-2 rounded-lg font-semibold w-28">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    <Modal :show="showDeleteHomeConfirmation">

    </Modal>
</template>
<script>
    export default {
        data(){
            return {
                showDeleteHomeConfirmation: false,
            }
        },
        methods: {
            
        }
    }
</script>