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
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Demote This User?</h2>
        <p class="text-gray-600 mb-4 text-md">Are you sure you want to demote this user as member?</p>
        <div class="flex justify-end">
            <button @click="demoteUser(userData);close()"
                class="flex-1 text-xs  bg-blue-500 hover:bg-blue-600 text-white   px-4 py-2 rounded-lg mr-4 hover-bg-gray-400 transition duration-300">
                Yes
            </button>
            <button @click="close()"
                class="flex-1 text-xs bg-gray-300 hover:bg-gray-400  text-gray-700 mr-6 px-4 py-2 rounded-lg hover-bg-red-600 transition duration-300">
                No, Cancel
            </button>
        </div>
    </div>
</template>
<script>
export default {
    methods:{
        close(){
            this.$emit('close');
        },
        demoteUser(userData) {
            this.$inertia.put(route('member.demote', { userData }), {
                onSuccess: () => {
                    close();
                },
            });
        },
    }
}
</script>