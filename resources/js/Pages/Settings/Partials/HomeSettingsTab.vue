<script setup>
import { defineEmits } from 'vue';
import LeaveHomeDialog from './LeaveHomeDialog.vue';
import DeleteHomeDialog from './DeleteHomeDialog.vue'
import Modal from '@/Components/Modal.vue';
const emit = defineEmits(['close']);
</script>
<template>
    <v-card-text>
        <div class="mx-3 flex flex-col w-1/2">
            <button @click="showDialog" v-if="$page.props.homeData.role == 'owner'"
                class="w-32 my-2 text-white bg-red-500 hover:bg-red-600 transition-colors duration-600 py-2 px-3 rounded-md text-md font-medium">
                Delete Home
            </button>
            <button @click="showDialog" v-else
                class="w-32 bg-zinc-500 hover:bg-zinc-800 transition-colors duration-600 text-white text-md p-2 rounded-md mb-4">
                Leave Home
            </button>
        </div>
    </v-card-text>
    <Modal maxWidth="sm" :show="homeSettingsDialog" @close="closeDialog">
        <template v-if="$page.props.homeData.role == 'owner'">
            <DeleteHomeDialog :homeID="$page.props.homeData.id"/>
        </template>
        <template v-else>
            <LeaveHomeDialog :userData="$page.props.auth" @close="closeDialog"/>
        </template>
    </Modal>
</template>
<script>
export default {
    data() {
        return {
            homeSettingsDialog: false,
        }
    },
    methods: {
        close(){
            this.$emit('close');
        },
        showDialog() {
            this.homeSettingsDialog = true;
        },
        closeDialog() {
            this.homeSettingsDialog = false;
        },
        deleteHome(user) {
            this.$inertia.delete(route('home.delete', { user }), {
                onSuccess: () => {
                    close();
                },
            });
        },
    }
}
</script>