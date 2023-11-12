<script setup>
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
</script>
<template>
    <v-window>
        <v-carousel height="280" hideDelimiters>
            <template v-slot:prev="{ props }">
                <button class="hover:scale-105 transition duration-500 ease-in-out" @click="props.onClick">
                    <v-img width="40" src="img-assets\vectors\Prev-Button.svg" />
                </button>
            </template>
            <template v-slot:next="{ props }">
                <button class="hover:scale-105 transition duration-500 ease-in-out" @click="props.onClick">
                    <v-img width="40" src="img-assets\vectors\Next-Button.svg" />
                </button>
            </template>
            <v-carousel-item v-for="room in rooms" class="px-2">
                <div class="px-7 py-4">
                    <div class="h-screen">
                        <v-card height="260">
                            <div class="container p-3 flex flex-col text-center">
                                <h1 class="text-lg font-semibold text-slate-600">
                                    {{ room.room_name }} ID:{{ room.id }}
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
                                    <div class="col-span-3 row-span-5 col-start-3 py-1">
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
                                    <div class="col-span-3 row-span-5 col-start-3 py-1">
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
            </v-carousel-item>
        </v-carousel>
    </v-window>
</template>
<script>
import { watch } from 'vue';
export default {
    props: {
        rooms: {
            type: Object,
            required: true,
        },
    },
};
</script>