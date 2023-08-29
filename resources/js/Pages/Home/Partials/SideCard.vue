<script setup>
    import ToggleSwitch from "@/Components/ToggleSwitch.vue";
    const toggleState = ref(false);
</script>
<template>
    <div
        class="p-6 flex w-9/12 flex-col items-center bg-white shadow-lg rounded-xl"
    >
        <h1 class="text-md font-semibold tracking-wide">{{ roomName }}</h1>
        <h2 class="text-sm mt-3 mb-4">({{ applianceCount }}) Appliances</h2>
        <div
            class="w-5/6 rounded-2xl min-h-16 h-auto flex border items-center justify-center mb-2"
        >
            <div class="flex flex-col items-center my-2">
                <h3 class="mb-2">{{ motionSensorName }}</h3>
                <ToggleSwitch v-model="toggleState" />
            </div>
        </div>
        <div
            class="grid grid-cols-5 grid-rows-5 gap-4 rounded-2xl w-5/6 h-16 border mb-2"
        >
            <div class="col-span-2 row-span-5">
                <div class="flex justify-center items-center w-full h-full">
                    <img class="h-9 w-auto" :src="temperatureIcon" alt="" />
                </div>
            </div>
            <div class="col-span-3 row-span-2 col-start-3">
                <h3 class="mb-2">{{ temperatureLabel }}</h3>
            </div>
            <div class="col-span-3 row-span-3 col-start-3 row-start-3">
                <div class="text-xl font-extrabold">{{ temperatureValue }}</div>
            </div>
        </div>
        <div
            class="grid grid-cols-5 grid-rows-5 gap-4 rounded-2xl w-5/6 h-16 border mb-2"
        >
            <div class="col-span-2 row-span-5">
                <div class="flex justify-center items-center w-full h-full">
                    <img class="h-9 w-auto" :src="humidityIcon" alt="" />
                </div>
            </div>
            <div class="col-span-3 row-span-2 col-start-3">
                <h3 class="mb-2">{{ humidityLabel }}</h3>
            </div>
            <div class="col-span-3 row-span-3 col-start-3 row-start-3">
                <div class="text-xl font-extrabold">{{ humidityValue }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        roomName: {
            type: String,
            required:false,
            default: "Living Room",
        },
        applianceCount: {
            type: Number,
            required:false,
            default: 2,
        },
        motionSensorName: {
            type: String,
            required:false,
            default: "Motion Sensor",
        },
        motionSensorState: {
            type: Boolean,
            required:false,
            default: false,
        },
        temperatureIcon: {
            type: String,
            required:false,
            default: "/img-assets/vectors/temperature.svg",
        },
        temperatureLabel: {
            type: String,
            required:false,
            default: "Temperature",
        },
        temperatureValue: {
            type: String,
            required:false,
            default: "32°",
        },
        humidityIcon: {
            type: String,
            required:false,
            default: "/img-assets/vectors/humidity.svg",
        },
        humidityLabel: {
            type: String,
            required:false,
            default: "Humidity",
        },
        humidityValue: {
            type: String,
            required:false,
            default: "60%",
        },
    },
};
</script>

<style scoped></style>
