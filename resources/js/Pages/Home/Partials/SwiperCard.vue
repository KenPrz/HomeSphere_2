<script setup>
import { ref } from "vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
const toggleState = ref(false);
</script>
<template>
    <div class="flex justify-center">
        <div
            class="p-6 flex w-11/12 lg:w-9/12 flex-col items-center bg-white shadow-lg rounded-xl"
        >
            <h1 class="text-md font-semibold tracking-wide">Living Room</h1>
            <h2 class="text-sm mt-3 mb-4">(2) Appliances</h2>
            <div
                class="w-11/12 lg:w-5/6 rounded-2xl min-h-16 h-auto flex border items-center justify-center mb-2"
            >
                <div class="flex flex-col items-center my-2">
                    <h3 class="mb-2">Motion Sensor</h3>
                    <ToggleSwitch v-model="toggleState" />
                </div>
            </div>
            <div
                class="grid grid-cols-5 grid-rows-5 gap-4 rounded-2xl w-11/12 lg:w-5/6 h-16 border mb-2"
            >
                <div class="col-span-2 row-span-5">
                    <div class="flex justify-center items-center w-full h-full">
                        <img
                            class="h-9 w-auto"
                            :src="'/img-assets/vectors/temperature.svg'"
                            alt=""
                        />
                    </div>
                </div>
                <div class="col-span-3 row-span-2 col-start-3">
                    <h3 class="mb-2">Temperature</h3>
                </div>
                <div class="col-span-3 row-span-3 col-start-3 row-start-3">
                    <div class="text-xl font-extrabold">32°</div>
                </div>
            </div>
            <div
                class="grid grid-cols-5 grid-rows-5 gap-4 rounded-2xl w-11/12 lg:w-5/6 h-16 border mb-2"
            >
                <div class="col-span-2 row-span-5">
                    <div class="flex justify-center items-center w-full h-full">
                        <img
                            class="h-9 w-auto"
                            :src="'/img-assets/vectors/humidity.svg'"
                            alt=""
                        />
                    </div>
                </div>
                <div class="col-span-3 row-span-2 col-start-3">
                    <h3 class="mb-2">Humidity</h3>
                </div>
                <div class="col-span-3 row-span-3 col-start-3 row-start-3">
                    <div class="text-xl font-extrabold">60%</div>
                </div>
            </div>
        </div>
    </div>
</template>
