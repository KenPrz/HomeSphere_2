<script setup>
import Modal from '@/Components/Modal.vue';
import EditRoomForm from './EditRoomForm.vue';
import DeleteRoomDialog from './DeleteRoomDialog.vue';
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import Device from '@/Pages/Rooms/Partials/Device.vue';
import MotionSensorToggle from '@/Components/MotionSensorToggle.vue';
</script>
<template>
    <div class="container">
        <div class="flex justify-center">
            <div class="md:w-2/3 bg-white rounded-xl w-full">
                <div class="flex flex-col p-5">
                    <div class="flex justify-between w-full pb-3 px-1 border-gray-500 border-b-2">
                        <div class="flex sm:text-md md:text-2xl font-semibold">
                            <span class="hidden me-2 sm:block">Appliances in</span> {{ room.room_name }}
                        </div>
                        <div v-if="room.room_owner_id == $page.props.auth.id || $page.props.homeData.role == 'owner'"
                            class="flex">
                            <button @click="openEditRoomForm"
                                class="flex items-center justify-center border-gray-500 border rounded-full px-2 mx-2 text-sm sm:text-md">
                                <img class="h-3 md:h-5 w-auto" :src="'img-assets/vectors/Edit.svg'" />
                                <span class="text-sm">Edit</span>
                            </button>
                            <button @click="openDeleteRoomDialog"
                                class="flex items-center justify-center border-gray-500 border rounded-full px-2 mx-2 text-sm sm:text-md">
                                <img class="h-3 md:h-5 w-auto" :src="'img-assets/vectors/Edit.svg'" />
                                <span class="text-sm">Delete</span>
                            </button>
                        </div>
                    </div>
                    <div class="md:hidden flex justify-around">
                        <div class="flex flex-col mt-1">
                            <div class="text-md font-semibold">
                                Temperature
                            </div>
                            <div class="text-sm font-light text-center">
                                <span v-if="tempData.data !== null">
                                    {{ tempData.data + '°C'}}
                                </span>
                                <span v-else>
                                    {{ room.temp_sensor.temperature + '°C'}}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col mt-1">
                            <div class="text-md font-semibold">
                                Humidity
                            </div>
                            <div class="text-sm font-light text-center">
                                <span v-if="humidityData.data !== null">
                                    {{ humidityData.data + '%'}}
                                </span>
                                <span v-else>
                                    {{ room.humidity_sensor.humidity + '%'}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-if="devices.data !== null" class="mt-3 container justify-center flex flex-wrap sm:justify-around max-h-[400px] md:max-h-[500px] md:justify-around overflow-y-scroll">
                        <Device v-for="device in devices.data" :key="device.id" :device="device" />
                    </div>
                    <div v-else class="mt-3 container justify-center flex flex-wrap sm:justify-around max-h-[400px] md:max-h-[500px] overflow-y-scroll">
                        <Device v-for="device in room.devices" :key="device.id" :device="device" />
                    </div>
                </div>
            </div>
            <div class="hidden md:block md:w-1/3 bg-gray-500 rounded-2xl ms-5 me-3">
                <div class="container p-5">
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full mb-3">
                        <MotionSensorToggle
                            :motionSensor="room.motion_sensor"
                            :userId="$page.props.auth.user.id"
                            :homeId="room.home_id"
                            :roomId="room.id"
                        />
                    </div>
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full mb-3">
                        <div class="text-xl text-white text-center mb-2">
                            Temperature
                        </div>
                        <div v-if="tempData.data !== null" class="flex w-full justify-center">
                            <v-progress-circular :size="150" :width="15" :rotate="0" :model-value="tempData.data"
                                color="white" background-color="rgba(255, 255, 255, 0.2)">
                                <span v-if="!tempData.data" class="text">no data</span>
                                <span v-else class="text">{{ tempData.data }}°C</span>
                            </v-progress-circular>
                        </div>
                        <div v-else class="flex w-full justify-center">
                            <v-progress-circular :size="150" :width="15" :rotate="0"
                                :model-value="room.temp_sensor.temperature" color="white"
                                background-color="rgba(255, 255, 255, 0.2)">
                                <span v-if="!room.temp_sensor.temperature" class="text">no data</span>
                                <span v-else class="text">{{ room.temp_sensor.temperature }}°C </span>
                            </v-progress-circular>
                        </div>
                    </div>
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full">
                        <div class="text-xl text-white text-center mb-2">
                            Humidity
                        </div>
                        <div v-if="humidityData.data !== null" class="flex w-full justify-center">
                            <v-progress-circular :size="150" :width="15" :rotate="0" :model-value="humidityData.data"
                                color="white" background-color="rgba(255, 255, 255, 0.2)">
                                <span v-if="!humidityData.data" class="text">no data</span>
                                <span v-else class="text">{{ humidityData.data }}%</span>
                            </v-progress-circular>
                        </div>
                        <div v-else class="flex w-full justify-center">
                            <v-progress-circular :size="150" :width="15" :rotate="0"
                                :model-value="room.humidity_sensor.humidity" color="white"
                                background-color="rgba(255, 255, 255, 0.2)">
                                <span v-if="!room.humidity_sensor.humidity" class="text">no</span>
                                <span v-else class="text">{{ room.humidity_sensor.humidity }}%</span>
                            </v-progress-circular>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal maxWidth="md" :show="showEditRoomForm" @close="closeEditRoomForm">
        <EditRoomForm :roomID="room.id" @close="closeEditRoomForm" />
    </Modal>
    <Modal maxWidth="sm" :show="showDeleteRoomDialog" @close="closeDeleteRoomDialog">
        <DeleteRoomDialog :roomID="room.id" @close="closeDeleteRoomDialog" />
    </Modal>
</template>
<script>
import { watch } from 'vue';
export default {
    props: {
        room: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            roomId: { ID: null },
            tempData: { data: null },
            humidityData: { data: null },
            devices:{data: null},
            showEditRoomForm: false,
            showDeleteRoomDialog: false,
            roomChannel: null,
        };
    },
    mounted() {
        this.subscribeToRoomChannel(this.room.id);
        watch(
            () => this.room.id,
            (newVal, oldVal) => {
                this.unsubscribeFromRoomChannel(oldVal);
                this.subscribeToRoomChannel(newVal);
            }
        );
    },
    unmounted(){
        this.unsubscribeFromRoomChannel(this.room.id);
    },
    methods: {
        subscribeToRoomChannel(room_id) {
            // Subscribe to the new channel
            this.roomChannel = window.Echo.private(`room.${room_id}`);
            this.roomChannel.subscribed(() => {
            }).listen('.sensor_update', (eventData) => {
                this.roomId.ID = eventData.sensor_data[0].id;
                this.tempData.data = eventData.sensor_data[0].temp_sensor.temperature;
                this.humidityData.data = eventData.sensor_data[0].humidity_sensor.humidity;
            })
        },
        unsubscribeFromRoomChannel(room_id) {
            window.Echo.leave(`room.${room_id}`);
            this.tempData.data = null;
            this.humidityData.data = null;
            this.devices.data = null;
        },
        close() {
            this.$emit('close');
        },
        openEditRoomForm() {
            this.showEditRoomForm = true;
        },
        closeEditRoomForm() {
            this.showEditRoomForm = false;
        },
        openDeleteRoomDialog() {
            this.showDeleteRoomDialog = true;
        },
        closeDeleteRoomDialog() {
            this.showDeleteRoomDialog = false;
        },
    },
};
</script>