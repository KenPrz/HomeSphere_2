<script setup>
import { ref, defineProps } from 'vue';
import { Link } from "@inertiajs/vue3";
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
const props = defineProps({
    room: {
        type: Object,
    }
});

</script>
<template>
    <div
        class="wrapper cursor-pointer shadow-md rounded-lg hover:scale-[1.01] transition duration-500 ease-in-out relative">
        <div class="flex flex-col text-center">
            <div class="living-room-card rounded-lg bg-white p-8 shadow-md ">
                <div class="living-room-settings flex">
                    <div class="left-section mx-7">
                        <div id="bedroom">
                            <img :src="'img-assets/vectors/Room Vectors/bathroom.svg'" alt="">
                        </div>
                        <h1 class="mt-4 text-xl font-medium">{{ room.room_name }}</h1>
                        <p class="mt-1 text-sm">{{ room.device_count + ' Appliance(s)' }}</p>
                    </div>
                    <div class="right-section ml-4 flex-grow mr-2">
                        <div class="flex flex-col items-start">
                            <div class="mt-3">
                                <h1 class="text-sm font-semibold">Temperature</h1>
                            </div>
                            <div class="flex w-full border border-gray-600 mt-1 h-6 rounded-full relative mb-2">
                                <span class="z-30 absolute right-1 pe-2">
                                    {{ room.temp_sensor.temperature + '°C' }}
                                </span>
                                <div class="rounded-full z-0 transition-width duration-500 ease-in-out"
                                    :style="{ width: room.temp_sensor.temperature + '%', backgroundColor: '#A9A9A9' }">
                                </div>
                            </div>

                            <div class="mt-1">
                                <p class="text-sm font-semibold">Humidity</p>
                            </div>
                            <div class="flex w-full border border-gray-600 mt-1 h-6 rounded-full relative mb-2">
                                <span class="z-30 absolute right-1 pe-2">
                                    {{ room.humidity_sensor.humidity + '%' }}
                                </span>
                                <div class="rounded-full z-0 transition-width duration-500 ease-in-out"
                                    :style="{ width: room.humidity_sensor.humidity + '%', backgroundColor: '#A9A9A9' }">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.transition-width {
    transition-property: width;
}</style>