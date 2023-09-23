<script setup>
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import { ref, defineProps } from 'vue';

const props = defineProps({
    // Define props here
    roomName: String,
    deviceCount: String,
    initialChecked: Boolean,
    temperature: Number,
    humidity: Number,
});
</script>

<template>
    <div class="flex flex-col text-center">
        <div class="living-room-card rounded-lg bg-white p-8 shadow-md">
            <div class="living-room-settings flex">
                <div class="left-section mx-7">
                    <div id="bedroom">
                        <img src="{{ asset('img-assets/vectors/bedroom.svg') }}" alt="bedroom">
                    </div>
                    <h1 class="mt-4 text-xl font-medium">{{ roomName }}</h1>
                    <p class="mt-1 text-sm">{{ deviceCount + ' Appliance(s)' }}</p>
                </div>
                <div class="right-section ml-4 flex-grow mr-2">
                    <div class="flex justify-end">
                        <label class="relative inline-flex cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" v-model="isChecked">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 dark:bg-gray-700 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="mt-3">
                            <h1 class="text-sm font-semibold">Temperature</h1>
                        </div>
                        <div class="flex w-full border border-gray-600 mt-1 h-6 rounded-full relative mb-2">
                            <span class="z-30 absolute right-1 pe-2">
                                {{ temperature + '°C' }}
                            </span>
                            <div class="rounded-full z-0" :style="{ width: temperature + '%', backgroundColor: '#A9A9A9' }">
                            </div>
                        </div>
                        <div class="mt-1">
                            <p class="text-sm font-semibold">Humidity</p>
                        </div>
                        <div class="flex w-full border border-gray-600 mt-1 h-6 rounded-full relative">
                            <span class="flex z-30 absolute right-1 pe-2">
                                {{ humidity + '%' }}
                            </span>
                            <div class="rounded-full z-0" :style="{ width: humidity + '%', backgroundColor: '#A9A9A9' }">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
