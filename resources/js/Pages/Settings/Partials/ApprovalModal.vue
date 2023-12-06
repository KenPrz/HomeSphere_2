<script setup>
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
    <div class="rounded-lg mt-2 ms-4 mb-1">
        <p class="text-gray-600 mb-4 text-md text-center">Do you want to approve this user's request to become a member?</p>

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