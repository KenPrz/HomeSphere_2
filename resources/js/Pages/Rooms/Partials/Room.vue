<script setup>
import Modal from '@/Components/Modal.vue';
import EditRoomForm from './EditRoomForm.vue';
import DeleteRoomDialog from './DeleteRoomDialog.vue';
import Device from '@/Pages/Rooms/Partials/Device.vue';
import MotionSensorToggle from '@/Components/MotionSensorToggle.vue';
import {defineEmits} from 'vue';
const emit = defineEmits(['roomDeleted']);
</script>
<template>
    <div class="container">
        <div class="flex justify-center">
            <div class="md:w-2/3 bg-white rounded-xl w-full">
                <div class="flex flex-col p-5">
                    <div class="flex justify-between w-full pb-3 px-1 border-gray-500 border-b-2">
                        <div class="w-full flex sm:text-md md:text-2xl font-semibold">
                            <span class="hidden me-2 sm:block overflow-ellipsis">Appliances in</span> {{ room_name.data }}
                        </div>
                        <div v-if="room.room_owner_id == $page.props.auth.user.id || $page.props.homeData.role == 'owner'"
                            class="flex">
                            <button @click="openEditRoomForm"
                                class="group flex items-center justify-center transition-all duration-200 hover:bg-gray-500 hover:text-white border-gray-500 border rounded-full px-2 mx-2 text-sm sm:text-md">
                                <svg class="group-hover:stroke-white transition-all duration-200 stroke-gray-500 h-3 md:h-5 w-auto"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                    <g id="SVGRepo_iconCarrier">
                                        <title />
                                        <g id="Complete">
                                            <g id="edit">
                                                <g>
                                                    <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" />
                                                    <polygon fill="none"
                                                        points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="text-sm">Edit</span>
                            </button>
                            <button @click="openDeleteRoomDialog"
                                class="group flex items-center justify-center transition-all duration-200 hover:bg-red-500 hover:text-white border-gray-500 border rounded-full px-2 text-sm sm:text-md">                                
                                <svg class="group-hover:stroke-white transition-all duration-200 stroke-gray-500 h-3 md:h-5 w-auto"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M4 7H20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6 7V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V7"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
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
                                    {{ tempData.data + '°C' }}
                                </span>
                                <span v-else>
                                    {{ room.temp_sensor.temperature + '°C' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col mt-1">
                            <div class="text-md font-semibold">
                                Humidity
                            </div>
                            <div class="text-sm font-light text-center">
                                <span v-if="humidityData.data !== null">
                                    {{ humidityData.data + '%' }}
                                </span>
                                <span v-else>
                                    {{ room.humidity_sensor.humidity + '%' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div v-if="devices.data !== null"
                        class="mt-3 container justify-center flex flex-wrap sm:justify-around max-h-[400px] md:max-h-[500px] md:justify-around overflow-y-scroll">
                        <Device v-for="device in devices.data" :key="device.id" :device="device" />
                    </div>
                    <div v-else
                        class="mt-3 container justify-center flex flex-wrap sm:justify-around max-h-[400px] md:max-h-[500px] overflow-y-scroll">
                        <Device v-for="device in room.devices" :key="device.id" :device="device" />
                    </div>
                </div>
            </div>
            <div class="hidden md:block md:w-1/3 bg-gray-500 rounded-2xl ms-5 me-3">
                <div class="container p-5">
                    <div class="flex-col border-white border-2 rounded-md p-3 items-center justify-center w-full mb-3">
                        <div class="text-xl text-white text-center">
                            Motion Sensor
                        </div>
                        <MotionSensorToggle :motionSensor="room.motion_sensor" :userId="$page.props.auth.user.id"
                            :homeId="room.home_id" :roomId="room.id" />
                        <div v-if="gasData.data !== null" class="mt-2 flex flex-col text-center text-white">
                            <span class="my-2 flex justify-center text-sm">
                                <h1>Gas Levels</h1>
                                <h2 v-if="!gasData.data" class="ms-1">null</h2>
                                <h2 v-else class="ms-1">{{ gasData.data }}%</h2>
                            </span>
                            <v-progress-linear
                                :model-value="gasData.data"
                                rounded
                                background-color="rgba(255, 255, 255, 0.2)"
                                color="rgba(255, 255, 255,)"
                            >
                            </v-progress-linear>
                        </div>
                        <div v-else class="mt-2 flex flex-col text-center text-white">
                            <span v-if="room.gas_sensor.gas_levels !== null" class="my-2 flex justify-center text-sm">
                                <h1>Gas Levels</h1>
                                <h2 class="ms-1">{{ room.gas_sensor.gas_levels }}%</h2>
                            </span>
                            <v-progress-linear
                                v-if="room.gas_sensor.gas_levels!==null"
                                :model-value="room.gas_sensor.gas_levels"
                                rounded
                                background-color="rgba(255, 255, 255, 0.2)"
                                color="rgba(255, 255, 255,)"
                            >
                            </v-progress-linear>
                        </div>
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
                    <div class="flex-col border-white border-2 rounded-md p-3 mb-3 items-center justify-center w-full">
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
    watch: {
        room: {
            handler: function (newVal, oldVal) {
                this.room_name.data = newVal.room_name;
            },
            deep: true,
        },
    },
    data() {
        return {
            room_name: {data: this.room.room_name},
            roomId: { ID: null },
            tempData: { data: null },
            humidityData: { data: null },
            gasData: { data: null },
            devices: { data: null },
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
    unmounted() {
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
                this.gasData.data = eventData.sensor_data[0].gas_sensor.gas_levels;
                this.humidityData.data = eventData.sensor_data[0].humidity_sensor.humidity;
            })
        },
        unsubscribeFromRoomChannel(room_id) {
            window.Echo.leave(`room.${room_id}`);
            this.tempData.data = null;
            this.humidityData.data = null;
            this.devices.data = null;
            this.gasData.data = null;
        },
        close() {
            this.$emit('close');
        },
        openEditRoomForm() {
            this.showEditRoomForm = true;
        },
        closeEditRoomForm(data) {
            if (data) {
                this.room_name.data = data;
            }
            this.showEditRoomForm = false;
        },
        openDeleteRoomDialog() {
            this.showDeleteRoomDialog = true;
        },
        closeDeleteRoomDialog(data) {
            if(data){
                this.refreshPage();
            }
            this.showDeleteRoomDialog = false;
        },
        refreshPage() {
            window.location.reload();
        },
    },
};
</script>
<style scoped>
    .overflow-ellipsis {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>