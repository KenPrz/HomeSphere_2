<script setup>
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
</script>
<template>
    <div class="px-7 py-4">
        <div class="h-screen">
            <v-card height="260">
                <div class="container p-3 flex flex-col text-center">
                    <h1 class="text-lg font-semibold text-slate-600">
                        {{ room.room_name }}
                    </h1>
                    <h3 class="text-xs font-light">
                        {{ room.device_count + ' ' }} Appliance(s)
                    </h3>
                </div>
                <div class="px-7">
                    <div class="rounded-xl border border-slate-300 w-full flex flex-col items-center p-1">
                        <div class="text-center text-sm font-medium">
                            Motion Sensor
                        </div>
                        <ToggleSwitch v-model="room.toggleState" />
                    </div>
                </div>
                <div class="px-7 mt-2">
                    <div class="grid grid-cols-5 grid-rows-5 gap-1 px-3 border rounded-xl">
                        <div class="col-span-2 row-span-5 py-1">
                            <div class="flex items-center justify-center mt-1">
                                <img class="w-9 ms-7" :src="'img-assets/vectors/temperature.svg'">
                            </div>
                        </div>
                        <div v-if="tempData.data !== null" class="col-span-3 row-span-5 col-start-3 py-1">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium">Temperature</h3>
                                <span v-if="tempData.data">{{ tempData.data + ' °C' }}</span>
                                <span v-else class="text-sm">no data</span>
                            </div>
                        </div>
                        <div v-else class="col-span-3 row-span-5 col-start-3 py-1">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium">Temperature</h3>
                                <span v-if="room.temp_sensor.temperature">{{ room.temp_sensor.temperature + ' °C' }}</span>
                                <span v-else class="text-sm">no data</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-7 mt-2">
                    <div class="grid grid-cols-5 grid-rows-5 gap-1 px-3 border rounded-xl">
                        <div class="col-span-2 row-span-5 py-1">
                            <div class="flex items-center justify-center mt-1">
                                <img class="w-8 ms-7" :src="'img-assets/vectors/humidity.svg'">
                            </div>
                        </div>
                        <div v-if="humidityData.data !== null" class="col-span-3 row-span-5 col-start-3 py-1">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium">Humidity</h3>
                                <span v-if="humidityData.data">{{ humidityData.data + ' %' }}</span>
                                <span v-else class="text-sm">no data</span>
                            </div>
                        </div>
                        <div v-else class="col-span-3 row-span-5 col-start-3 py-1">
                            <div class="flex flex-col">
                                <h3 class="text-sm font-medium">Humidity</h3>
                                <span v-if="room.humidity_sensor.humidity">{{ room.humidity_sensor.humidity + ' %' }}</span>
                                <span v-else class="text-sm">no data</span>
                            </div>
                        </div>
                    </div>
                </div>
            </v-card>
        </div>
    </div>
</template>
<script>
import {watch} from 'vue';
    export default {
        props: {
            room:{
                type: Object,
                required: true,
            }
        },
        data() {
        return {
            roomId: { ID: this.$props.room.id },
            tempData: { data: this.$props.room.temp_sensor.temperature},
            humidityData: { data: this.$props.room.humidity_sensor.humidity },
            devices:{data: this.$props.room.devices},
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
    methods: {
        subscribeToRoomChannel(room_id) {
            this.roomChannel = window.Echo.private(`room.${room_id}`);
            this.roomChannel.subscribed(() => {
            }).listen('.sensor_update', (eventData) => {
                this.roomId.ID = eventData.sensor_data[0].id;
                this.tempData.data = eventData.sensor_data[0].temp_sensor.temperature;
                this.humidityData.data = eventData.sensor_data[0].humidity_sensor.humidity;
            }).listen('.device_update',(eventData)=>{
                this.devices.data = eventData.device_data[0].devices;
            });
        },
        unsubscribeFromRoomChannel(room_id) {
            window.Echo.leave(`room.${room_id}`);
            this.tempData.data = null;
            this.humidityData.data = null;
            this.devices.data = null;
        },
    }
}
</script>