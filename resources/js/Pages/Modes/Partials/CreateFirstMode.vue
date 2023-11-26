<script setup>
import Modal from '@/Components/Modal.vue';
import AddMode from './AddMode.vue';
</script>
<template>
    <v-card>
        <div class="container p-3">
            <h1 class="text-lg font-semibold text-center">
                Welcome to modes! You can create your first mode by clicking the button below.
            </h1>
            <button @click="openAddModeModal" type="button" class="flex flex-col items-center justify-center h-48 w-48 p-6 hover:bg-slate-300 transition-colors duration-200 rounded-2xl m-3 bg-slate-400">
                <svg class="h-32 w-auto" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path> <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
                <span class="text-white text-sm">Add mode</span>
            </button>
        </div>
    </v-card>
    <Modal :hasClose="false" :maxWidth="'md'" :show="showAddModeModal" @close="closeAddModeModal">
        <div class="p-4 bg-white shadow sm:rounded-lg">
            <AddMode @close="closeAddModeModal" :title="'Create your first mode'"/>
        </div>
    </Modal>
</template>
<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            showAddModeModal: false,
        }
    },
    methods: {
        openAddModeModal() {
            this.showAddModeModal = true;
        },
        closeAddModeModal() {
            this.showAddModeModal = false;
        }
    }
}
</script>