<script setup>
import Modal from '@/Components/Modal.vue'
import NewApiKeyDialog from './NewApiKeyDialog.vue';
import NewInviteKeyDialog from './NewInviteKeyDialog.vue';
</script>
<template>
    <div class="mx-3">
        <h1 class="text-md font-medium">Home Codes</h1>
    </div>
    <v-container class="flex flex-col">
        <v-card class="my-3" title="Invite Code" subtitle="This is your unique invite code">
            <v-card-text>
                <div class="flex flex-col">
                    <span class="font-medium p-1">
                        {{$page.props.homeData.invite_code}}
                    </span>
                    <button @click="copyToClipboard($page.props.homeData.invite_code)"
                        class="bg-zinc-400 hover:bg-zinc-500 transition-colors duration-200 text-white text-md p-2 rounded-md mb-4 w-64 mt-2">
                        <span class="font-medium">Copy Invite Code</span>
                    </button>
                </div>
                <button @click="openInviteKeyGenDialog" v-if="$page.props.homeData.owner_id == $page.props.auth.user.id"
                    class="bg-zinc-600 hover:bg-zinc-700 transition-colors duration-200 text-white text-md p-2 rounded-md mb-4 w-64">
                    Generate new invite code
                </button>
            </v-card-text>
        </v-card>
        <v-card title="Api Key" subtitle="Your hardware API key"
            v-if="$page.props.api_key">
            <v-card-text>
                <div class="flex flex-col">
                    <span class="font-medium p-1">
                        {{ $page.props.api_key.api_key }}
                    </span>
                    <button @click="copyToClipboard($page.props.api_key.api_key)"
                        class="bg-zinc-400 hover:bg-zinc-500 transition-colors duration-200 text-white text-md p-2 rounded-md mb-4 w-64 mt-2">
                        Copy API Key
                    </button>
                </div>
                <button @click="openApiKeyGenDialog"
                    class="bg-zinc-600 hover:bg-zinc-700 transition-colors duration-200 text-white text-md p-2 rounded-md w-64 mb-4">
                    Generate new API key
                </button>
            </v-card-text>
        </v-card>
    </v-container>

    <Modal maxWidth="md" :show="showApiKeyGenDialog" @close="closeApiKeyGenDialog">
        <NewApiKeyDialog @close="closeApiKeyGenDialog"/>
    </Modal>

    <Modal maxWidth="md" :show="showInviteKeyGenDialog" @close="closeInviteKeyGenDialog">
        <NewInviteKeyDialog :homeData="$page.props.homeData" @close="closeInviteKeyGenDialog"/>
    </Modal>
</template>
<script>
    export default {
        data(){
            return {
                showApiKeyGenDialog: false,
                showInviteKeyGenDialog: false,
            }
        },
        methods:{
            openApiKeyGenDialog(){
                this.showApiKeyGenDialog = true;
            },
            closeApiKeyGenDialog(){
                this.showApiKeyGenDialog = false;
            },
            openInviteKeyGenDialog(){
                this.showInviteKeyGenDialog = true;
            },
            closeInviteKeyGenDialog(){
                this.showInviteKeyGenDialog = false;
            },
            copyToClipboard(text) {
                const input = document.createElement('input');
                input.value = text;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
            }
        }
    }
</script>
