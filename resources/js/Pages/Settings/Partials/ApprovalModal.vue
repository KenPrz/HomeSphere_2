<script setup>
import { router } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const emit = defineEmits(['close']);

    defineProps({
        userData:{
            type:Object,
            required:true
        }
    });
</script>
<template>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <!-- <button @click="close" class="bg-red-500 hover:bg-red-600 p-2 rounded-md text-white">TestEmit</button> -->
        <h2 class="text-xl font-semibold mb-4">Approve User Membership Request?</h2>
        <p class="text-gray-600 mb-4 text-md">Do you want to approve this user's request to become a member?</p>
        <div class="flex justify-end">
            <button @click="approveUser(userData)"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg mr-4 hover-bg-gray-400 transition duration-300">
                Yes, approve
            </button>
            <button @click="rejectUser(userData)"
                class="flex-1 bg-red-500 hover:bg-red-600 text-white mr-6 px-4 py-2 rounded-lg hover-bg-red-600 transition duration-300">
                No, Reject
            </button>
        </div>
    </div>
</template>
<script>
export default {
    methods:{
        close() {
            this.$emit('close');
        },
        approveUser(userData) {
            this.$inertia.post(route('member.approve', { userData }), {
                onSuccess: () => {
                    this.close();
                },
            });
            this.close();
        },
        rejectUser(userData) {
            this.$inertia.delete(route('member.reject', { userData }), {
                onSuccess: () => {
                    this.close();
                },
            });
        },
    }
}
</script>