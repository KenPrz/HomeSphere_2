<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['close']);

    defineProps({
        roomID:{
            type:Number,
            required:true
        }
    });
</script>
<template>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <!-- <button @click="close" class="bg-red-500 hover:bg-red-600 p-2 rounded-md text-white">TestEmit</button> -->
        <h2 class="text-xl font-semibold mb-4">Delete this room?</h2>
        <div class="flex justify-end">
            <button @click="deleteRoom(roomID)"
                class="flex-1 bg-red-500 hover:bg-red-600 text-white mr-6 px-4 py-2 rounded-lg hover-bg-red-600 transition duration-300">
                Yes, Delete
            </button>
            <button @click="close"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg mr-4 hover-bg-gray-400 transition duration-300">
                No, Cancel
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
        deleteRoom(roomID) {
            this.$inertia.delete(route('rooms.delete', { roomID }), {
                onSuccess: () => {
                    this.close();
                },
            });
            this.close();
        },
    }
}
</script>