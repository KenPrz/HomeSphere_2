<script setup>
import { defineEmits } from 'vue';
import Modal from '@/Components/Modal.vue';
import NewApiKeyForm from './NewApiKeyForm.vue';
const emit = defineEmits(["close"]);
</script>
<template>
    <div class="modal-container p-6 mx-auto my-2 bg-white">
        <h2 class="text-2xl font-semibold mb-4">Regenerate API Key</h2>
        <p class="text-base text-gray-600 leading-normal">
            Are you sure you want to regenerate your API key? Regenerating a new API key will require you to reconfigure all
            connected devices. This action should only be taken if you suspect that your current API key has been
            compromised.
        </p>
        <p class="text-red-600 mt-4">
            <span class="font-semibold">Warning:</span>
            Regenerating the key unnecessarily can disrupt your service and require additional effort to reconfigure your
            devices. It is recommended to change your API key only when you have a valid reason to believe it's compromised.
        </p>
        <div class="mt-4 flex justify-start">
            <button class="px-2 py-3 text-white bg-blue-500 rounded-md hover:bg-blue-600" @click="openRegenerateApiForm">Proceed
                with Key Regeneration</button>
            <button class="px-7 py-3 text-gray-700 bg-gray-300 rounded-md ml-4 hover:bg-gray-400"
                @click="close">Cancel</button>
        </div>
    </div>
    <Modal maxWidth="md" :show="showNewApiForm" @close="closeRegenerateApiForm">
        <NewApiKeyForm/>
    </Modal>
</template>
<script>
    export default {
        data(){
            return {
                showNewApiForm: false,
            }
        },
        methods:{
            close() {
                this.$emit('close');
            },
            openRegenerateApiForm(){
                this.showNewApiForm = true;
            },
            closeRegenerateApiForm(){
                this.showNewApiForm = false;
            }
        }
    }
</script>
