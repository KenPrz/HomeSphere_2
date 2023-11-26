<script setup>
import { ref } from "vue";
import { defineEmits } from "vue";
const emit = defineEmits(["close"]);
function cancel() {
    emit("close");
}
</script>
<template>
    <div class="container bg-white rounded-xl">
        <form action="#" class="flex flex-col my-10 mx-10">
            <div class="text-2xl font-semibold mb-3">
                Add Appliance
            </div>
            <div class="mb-4">
                <label for="select1" class="block text-gray-700 font-medium mb-2">Room</label>
                <select v-model="selectedRoom" @change="updateAppliances" id="select1" name="select1"
                    class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="" disabled>Select a room</option>
                    <option v-for="room in roomsData" :key="room.id" :value="room.id">{{ room.room_name }}</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="select2" class="block text-gray-700 font-medium mb-2">Appliance</label>
                <select v-model="selectedAppliance" id="select2" name="select2"
                    class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="" disabled>Select an appliance</option>
                    <option v-for="device in selectedRoomDevices" :key="device.id" :value="device.id">{{ device.device_name
                    }}</option>
                </select>
            </div>
            <div class="flex flex-row justify-center mt-5">
                <button type="submit"
                    class="flex-1 bg-gray-500 hover:bg-gray-400 transition-colors duration-200 text-white font-semibold py-2 px-4 rounded-full me-2">
                    Add
                </button>
                <button @click="cancel"
                    class="flex-1 bg-white border-2 hover:bg-gray-200 transition-colors duration-200 text-slate-900 font-semibold py-2 px-4 rounded-full">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props: {
        roomsData: {
            type: Array,
            default: null,
        },
    },
    data() {
        return {
            selectedRoom: '',
            selectedAppliance: '',
        };
    },
    computed: {
        selectedRoomDevices() {
            const selectedRoom = this.roomsData.find(room => room.id === parseInt(this.selectedRoom));
            return selectedRoom ? selectedRoom.devices : [];
        },
    },
    methods: {
        updateAppliances() {
            // Optionally, you can add logic here to handle changes when the room selection changes
        },
        handleSubmit() {
            // Handle form submission logic here
            console.log('Selected Room:', this.selectedRoom);
            console.log('Selected Appliance:', this.selectedAppliance);
        },
        cancel() {
            this.$emit('close');
        },
    },
};
</script>