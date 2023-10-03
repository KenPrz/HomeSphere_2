<script setup>
import { ref } from 'vue';
import "vue3-circle-progress/dist/circle-progress.css";
import CircleProgress from "vue3-circle-progress";
import ToggleSwitch from '@/Components/ToggleSwitch.vue';

defineProps({
    room: {
        type: Object,
    },
    devices: {
        type: Object,
    },
});
    
</script>
<template>
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-6 grid-rows-5 gap-2">
            <div class="col-span-1 md:col-span-4 row-span-1 md:row-span-5 bg-white rounded-xl p-4">
                <div class="flex flex-col">
                    <div class="flex justify-between w-full pb-3 px-1 border-gray-500 border-b-2">
                        <div class="text-2xl font-semibold">
                            Appliances in {{ roomName }}
                        </div>
                        <div class="flex">
                            <button class="flex items-center justify-center border-gray-500 border rounded-full px-3 mx-2">
                                <img class="h-4 w-auto" :src="'img-assets/vectors/Edit.svg'" />
                                <span>Edit</span>
                            </button>
                            <button class="flex items-center justify-center border-gray-500 border rounded-full px-3">
                                <img class="h-4 w-auto" :src="'img-assets/vectors/add.svg'" />
                                <span>Add</span>
                            </button>
                        </div>
                    </div>
                    <div class="container flex flex-wrap">
                        {{ room }}
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
                            <ToggleSwitch/>
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
                                :model-value="temperature"
                                color="white"
                                background-color="rgba(255, 255, 255, 0.2)"
                            >
                                <span class="text">{{ temperature }}°C</span>
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
                                :model-value="humidity"
                                color="white"
                                background-color="rgba(255, 255, 255, 0.2)"
                            >
                                <span class="text">{{ humidity }}%</span>
                            </v-progress-circular>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components: {CircleProgress}
}
</script>
<style scoped>
.text {
    font-size: 1.5rem;
    font-weight: 200;
    color: #fff;
}
</style>