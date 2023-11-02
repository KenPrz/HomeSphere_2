<script setup>
import Modal from '@/Components/Modal.vue'
import NewApiKeyDialog from './NewApiKeyDialog.vue';
</script>
<template>
    <div class="mx-3">
        <h1 class="text-md font-medium">Home Codes</h1>
    </div>
    <v-container class="flex flex-col">
        <v-card class="my-3" title="Invite Code" subtitle="This is your unique invite code"
            :text="$page.props.homeData.invite_code">
            <v-card-subtitle>
                <button v-if="$page.props.homeData.owner_id == $page.props.auth.user.id"
                    class="bg-zinc-950 hover:bg-zinc-800 transition-colors duration-200 text-white text-md p-2 rounded-md mb-4">
                    Generate new invite code
                </button>
            </v-card-subtitle>
        </v-card>
        <v-card title="Api Key" subtitle="Your hardware API key" :text="$page.props.api_key.api_key"
            v-if="$page.props.api_key">
            <v-card-subtitle>
                <button @click="showDialog"
                    class="bg-zinc-950 hover:bg-zinc-800 transition-colors duration-200 text-white text-md p-2 rounded-md mb-4">
                    Generate new API key
                </button>
            </v-card-subtitle>
        </v-card>
    </v-container>
    <Modal maxWidth="md" :show="showKeyGenDialog" @close="closeDialog">
        <NewApiKeyDialog @close="closeDialog"/>
    </Modal>
</template>
<script>
    export default {
        data(){
            return {
                showKeyGenDialog: false,
            }
        },
        methods:{
            showDialog(){
                this.showKeyGenDialog = true;
            },
            closeDialog(){
                this.showKeyGenDialog = false;
            }
        }
    }
</script>