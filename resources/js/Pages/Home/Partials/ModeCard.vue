<template>
    <div>
        <div
            :class="[
                'm-3 p-3 flex flex-col h-[160px] w-[160px] bg-gray-600 shadow-lg rounded-lg hover:scale-105 cursor-pointer transition duration-500 ease-in-out',
                customClass,
                toggleState ? 'bg-white text-black' : 'bg-gray-600 text-white',
            ]"
        >
            <div class="flex flex-1">
                <div class="flex-1">{{ logo }}</div>
                <div class="flex-1">
                    <div>
                        <ToggleSwitch v-model="toggleState" />
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-1">
                <h2 class="text-1xl">{{ cardName }}</h2>
                <h1 class="text-2xl font-ex">{{ toggleState ? "ON" : "OFF" }}</h1>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
const toggleState = ref(false);
</script>

<script>
export default {
    props: {
        customClass: {
            type: String,
            required: false,
            default: "",
        },
        logo: {
            type: String,
            required: false,
            default: "Logo",
        },
        toggleSwitch: {
            type: String,
            required: false,
            default: "Toggle Switch",
        },
        cardName: {
            type: String,
            required: false,
            default: "Default",
        },
        cardState: {
            type: String,
            required: false,
            default: "On/Off",
        },
    },
};
</script>
