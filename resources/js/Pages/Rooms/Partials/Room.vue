<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import EditRoomForm from './EditRoomForm.vue';
import DeleteRoomDialog from './DeleteRoomDialog.vue';
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import Device from '@/Pages/Rooms/Partials/Device.vue';
defineProps({
    room: {
        type: Object,
    }
});
    
</script>
<template>
    <div class="container">
        <!-- <div v-for="device in room.devices" :key="device.id">
            {{ device.is_active }}
        </div> -->
        <div class="grid grid-cols-1 md:grid-cols-6 grid-rows-5 gap-2">
            <div class="col-span-1 md:col-span-4 row-span-1 md:row-span-5 bg-white rounded-xl p-4">
                <div class="flex flex-col">
                    <div class="flex justify-between w-full pb-3 px-1 border-gray-500 border-b-2">
                        <div class="text-2xl font-semibold">
                            Appliances
                        </div>
                        <div v-if="room.room_owner_id == $page.props.auth.id || $page.props.homeData.role == 'owner'" class="flex">
                            <button @click="openEditRoomForm" class="flex items-center justify-center border-gray-500 border rounded-full px-3 mx-2">
                                <img class="h-4 w-auto" :src="'img-assets/vectors/Edit.svg'" />
                                <span>Edit</span>
                            </button>
                            <button @click="openDeleteRoomDialog" class="flex items-center justify-center border-gray-500 border rounded-full px-3 mx-2">
                                <img class="h-4 w-auto" :src="'img-assets/vectors/Edit.svg'" />
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 container flex flex-wrap sm:justify-around md:justify-between">
                        <!-- {{ room }} -->
                        <Device v-for="device in room.devices"
                            :key="device.id" 
                            :device="device"
                        />
                    </div>
                </div>
            </div>
            <div class="col-span-1 md:col-span-2 row-span-1 md:row-span-5 col-start-1 md:col-start-5 bg-gray-500 rounded-xl mx-10">
                <div class="container p-5">
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full mb-3">
                        <div class="text-xl text-white text-center mb-2">
                            Motion Sensor
                        </div>
                        <div class="flex items-center justify-center">
                            <ToggleSwitch
                            />
                        </div>
                    </div>
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full mb-3">
                        <div class="text-xl text-white text-center mb-2">
                            Temperature
                        </div>
                        <div class="flex w-full justify-center">
                            <v-progress-circular
                                :size="150"
                                :width="15"
                                :rotate="0"
                                :model-value="room.temp_sensor.temperature"
                                color="white"
                                background-color="rgba(255, 255, 255, 0.2)"
                            >
                                <span v-if="!room.temp_sensor.temperature" class="text">no data</span>
                                <span v-else class="text">{{ room.temp_sensor.temperature }}°C</span>
                            </v-progress-circular>
                        </div>
                    </div>
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full">
                        <div class="text-xl text-white text-center mb-2">
                            Humidity
                        </div>
                        <div class="flex w-full justify-center">
                            <v-progress-circular
                                :size="150"
                                :width="15"
                                :rotate="0"
                                :model-value="room.humidity_sensor.humidity"
                                color="white"
                                background-color="rgba(255, 255, 255, 0.2)"
                            >   
                                <span v-if="!room.humidity_sensor.humidity" class="text">no data</span>
                                <span v-else class="text">{{ room.humidity_sensor.humidity }}%</span>
                            </v-progress-circular>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal maxWidth="md" :show="showEditRoomForm" @close="closeEditRoomForm">
        <EditRoomForm :roomID="room.id" @close="closeEditRoomForm"/>
    </Modal>
    <Modal maxWidth="sm" :show="showDeleteRoomDialog" @close="closeDeleteRoomDialog">
        <DeleteRoomDialog :roomID="room.id" @close="closeDeleteRoomDialog"/>
    </Modal>
</template>
<script>
export default {
    data(){
        return {
            showEditRoomForm: false,
            showDeleteRoomDialog:false,
        }
    },
    methods: {
        close() {
            this.$emit('close');
        },
        openEditRoomForm(){
            this.showEditRoomForm = true;
        },
        closeEditRoomForm(){
            this.showEditRoomForm = false;
        },
        openDeleteRoomDialog(){
            this.showDeleteRoomDialog = true;
        },
        closeDeleteRoomDialog(){
            this.showDeleteRoomDialog = false;
        },
    }
}
</script>
<style scoped>
.text {
    font-size: 1.5rem;
    font-weight: 200;
    color: #fff;
}
</style>