<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const emit = defineEmits(['close']);

const roomProps = defineProps({
    roomID:{
        type:Number,
        required:true
    }
});
const deleteRoomForm = useForm({
    room_id: roomProps.roomID,
});
const deleteRoom = () => {
    const data = roomProps.roomID;
    deleteRoomForm.delete(route('rooms.delete'), {
        onSuccess: () => {
            close(data);
        },
    });
};
function cancel(){
    emit('close');
}
function close(data){
    emit('close',data);
}

</script>
<template>
    <div class="bg-white p-3 rounded-lg shadow-md">
        <!-- <button @click="close" class="bg-red-500 hover:bg-red-600 p-2 rounded-md text-white">TestEmit</button> -->
        <h2 class="text-xl font-semibold mb-4">Delete this room?</h2>
        <div class="flex justify-end">
            <form class=" text-center flex-1 text-sm bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300" @submit.prevent="deleteRoom">
                <button
                    type="submit"
                    
                >
                    Yes, Delete it
                </button>
                
            </form>
            <button @click="cancel"
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg mr-4 hover-bg-gray-400 transition duration-300">
                No, Cancel
            </button>
        </div>
    </div>
</template>