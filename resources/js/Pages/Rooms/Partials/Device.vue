<script setup>
import ToggleSwitch from "@/Components/ToggleSwitch.vue";

const { device, customClass } = defineProps({
    device: Object,
    customClass: String,
});
</script>

<template>
    <div>
        <div :class="[
            'm-3 p-3 flex flex-col bg-gray-600 shadow-lg rounded-lg hover:scale-105 cursor-pointer transition duration-500 ease-in-out',
            customClass,
            is_online.data ? '' : 'bg-gray-400 important:text-black',
            is_active.data ? 'bg-white text-black' : 'bg-gray-600 text-white',
            'w-[115px] h-[115px] sm:h-[125px] sm:w-[125px] md:w-[140px] md:h-[140px] lg:w-[150px] lg:h-[150px]',
        ]">
            <div class="flex flex-1">
                <div v-if="device.device_type === 'light'" class="flex-1">
                    <svg class="h-10" :fill="is_active.data ? 'black' : '#A9A9A9'" viewBox="0 0 512 512"
                        xml:space="preserve">
                        <path
                            d="M428.2 172.2c0-47.5-19.3-90.6-50.4-121.8A171.7 171.7 0 0 0 256 0c-47.5 0-90.6 19.3-121.8 50.4a171.7 171.7 0 0 0-26.7 209h.1l.1.3c11 19.4 26.7 34.7 39 48.8 6.1 7 11.4 13.8 15 20a39 39 0 0 1 5.5 17.6v95.4a53.3 53.3 0 0 0 53.3 53.3h7.6a31.3 31.3 0 0 0 55.8 0h7.6a53.3 53.3 0 0 0 53.3-53.3V346c.2-5.7 2-11.3 5.5-17.6a194 194 0 0 1 24.8-30.9c10-11.2 21-23.3 29.2-38l.2-.2a171 171 0 0 0 23.7-87.2zM311.8 461.8a28.5 28.5 0 0 1-20.3 8.4h-71a28.5 28.5 0 0 1-28.7-28.7v-5.3l120 25.5zm8.4-20.3c0 1.7-.2 3.4-.5 5l-128-27.1v-33.5l128.5 27.3v28.3zm0-45.1-128.4-27.3v-11h128.4v38.3zm63-149.3-.2.2v.1c-8.5 15.4-23 29.9-36.2 45a151 151 0 0 0-17.9 24c-3 5.2-5.3 11-6.9 17H190c-1.6-6-4-11.8-7-17-7.4-13-17.8-24.1-27.9-35.3a191.9 191.9 0 0 1-26-33.7l-.2-.1v-.2a147 147 0 0 1 22.8-179.3A147 147 0 0 1 256 24.6a147 147 0 0 1 104.4 43.2A147 147 0 0 1 383 247.1z" />
                    </svg>
                </div>
                <div v-else class="flex-1">
                    <svg class="h-10" :fill="is_active.data ? 'black' : 'white'" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 9v3a5 5 0 0 1-5 5M7 9v3a5 5 0 0 0 5 5m0 0v4M8 3v3m8-3v3M5 9h14" stroke="#000"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="ms-5 mt-1">
                        <ToggleSwitch v-if="is_online.data" @click="submit()" v-model="is_active.data" />
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-1">
                <!-- Adjust text size based on screen size -->
                <h2 class="text-sm sm:text-md lg:text-lg overflow-ellipsis">
                    <span v-if="device.custom_name!=null">
                        {{ device.custom_name }}
                    </span>
                    <span v-else>
                        {{ device.device_name }}
                    </span>
                </h2>
                <h1 v-if="is_online.data == false" class="text-lg sm:text-xl lg:text-2xl font-ex">
                    Offline
                </h1>
                <h1 v-else class="text-lg sm:text-xl lg:text-2xl font-ex">
                    {{ is_active.data ? 'ON' : 'OFF' }}
                </h1>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: {
        device: Object,
        customClass: String,
    },
    data() {
        return {
            is_active: {data: this.device.is_active},
            is_online: {data: true},
        }
    },
    mounted() {
        this.verifyIfDeviceIsOnline(this.device.last_access);
        this.subscribeToRoomChannel(this.device.room_id);
    },
    unmounted(){
        this.unsubscribeFromRoomChannel(this.device.room_id);
    },
    methods: {
        subscribeToRoomChannel(room_id) {
            // Subscribe to the new channel
            this.roomChannel = window.Echo.private(`room.${room_id}`);
            this.roomChannel.subscribed(() => {
            }).listen('.device_update', (eventData) => {
                if(this.device.id==eventData.device_data.device_id)
                {
                    this.is_active.data=eventData.device_data.device_state;
                }
            }).listen('.device_online', (eventData) => {
                if(this.device.id==eventData.device_data.device_id)
                {
                    this.monitorDeviceActivity(eventData.device_data.is_online);
                }
            });
        },
        unsubscribeFromRoomChannel(room_id) {
            window.Echo.leave(`room.${room_id}`);
        },
        submit() {
            axios.post(`/api/device-toggle`, {
                device_id: this.device.id,
                room_id: this.device.room_id,
                is_active: this.is_active.data,
            })
                .then(response => {
                    // Handle the response as needed.
                    // console.log(response); //for debugging only remove at prod
                })
                .catch(error => {
                    console.log(error); //for debugging only remove at prod
                });
        },
        monitorDeviceActivity(isDeviceOnline){
            if(isDeviceOnline){
                this.is_online.data=true;
            }
            else{
                this.is_online.data=false;
            }
        },
        verifyIfDeviceIsOnline(last_access){
            var last_access_date = new Date(last_access);
            var current_date = new Date();
            var time_difference = current_date.getTime() - last_access_date.getTime();
            var seconds_difference = time_difference / 1000;
            if(seconds_difference>60){
                this.is_online.data=false;
            }
            else{
                this.is_online.data=true;
            }
        }
    },
    watch: {
        'device.is_active': function () {
            this.submit();
        },  
    },
}
</script>
<style scoped>
.overflow-ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
/**
 * Component for displaying a device in a room.
 * 
 * @props {Object} device - The device object.
 * @props {String} customClass - The custom CSS class for the device.
 * 
 * @data {Object} is_active - The data object for the device's active state.
 * 
 * @method subscribeToRoomChannel - Subscribes to the room channel for device updates.
 * @param {Number} room_id - The ID of the room.
 * 
 * @method unsubscribeFromRoomChannel - Unsubscribes from the room channel.
 * @param {Number} room_id - The ID of the room.
 * 
 * @method submit - Submits the device data to the server.
 * @param {Object} data - The data object to be submitted.
 * 
 * @watch device.is_active - Watches for changes in the device's active state and triggers the submit method.
 */