<template>
    <div
        class="wrapper cursor-pointer shadow-md rounded-lg hover:scale-[1.01] transition duration-500 ease-in-out relative">
        <div class="flex flex-col text-center">
            <div class="living-room-card rounded-lg bg-white p-8 shadow-md ">
                <div class="living-room-settings flex">
                    <div class="left-section mx-7 w-1/4">
                        <div id="bedroom">
                            <v-img v-if="room.room_icon!=null" class="rounded-md mx-auto" width="70" :aspect-ratio="1"
                                :src="room.room_icon" cover></v-img>
                            <v-img v-else class="rounded-md mx-auto" width="70" :aspect-ratio="1"
                            :src="'img-assets/nav-vectors/rooms.svg'" cover></v-img>
                        </div>
                        <h1 class="overflow-ellipsis mt-4 text-xl font-medium">{{ room.room_name }}</h1>
                        <p class="mt-1 text-sm">{{ room.device_count + ' Appliance(s)' }}</p>
                    </div>
                    <div class="right-section ml-4 flex-grow mr-2">
                        <div class="flex flex-col items-start">
                            <div class="mt-3">
                                <h1 class="text-sm font-semibold">Temperature</h1>
                            </div>
                            <div class="flex w-full border border-gray-600 mt-1 h-6 rounded-full relative mb-2">
                                <span class="z-30 absolute right-1 pe-2">
                                    {{ tempData.data + '°C' }}
                                </span>
                                <div class="rounded-full z-0 transition-width duration-500 ease-in-out"
                                    :style="{ width: tempData.data + '%', backgroundColor: '#A9A9A9' }">
                                </div>
                            </div>

                            <div class="mt-1">
                                <p class="text-sm font-semibold">Humidity</p>
                            </div>
                            <div class="flex w-full border border-gray-600 mt-1 h-6 rounded-full relative mb-2">
                                <span class="z-30 absolute right-1 pe-2">
                                    {{ humidityData.data + '%' }}
                                </span>
                                <div class="rounded-full z-0 transition-width duration-500 ease-in-out"
                                    :style="{ width: humidityData.data + '%', backgroundColor: '#A9A9A9' }">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            room: {
                type: Object,
                required: true,
            },
        },
        data(){
            return {
                tempData: { data: this.room.temp_sensor.temperature },
                humidityData: { data: this.room.humidity_sensor.humidity },
            }
        },
        mounted() {
            this.subscribeToRoomChannel(this.room.id);
        },
        methods: {
            subscribeToRoomChannel(room_id) {
            // Subscribe to the new channel
            this.roomChannel = window.Echo.private(`room.${room_id}`);
            this.roomChannel.subscribed(() => {
            }).listen('.sensor_update', (eventData) => {
                this.tempData.data = eventData.sensor_data[0].temp_sensor.temperature;
                this.humidityData.data = eventData.sensor_data[0].humidity_sensor.humidity;
            })
        },
        }
    }
</script>
<style scoped>
.overflow-ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.transition-width {
    transition-property: width;
}</style>