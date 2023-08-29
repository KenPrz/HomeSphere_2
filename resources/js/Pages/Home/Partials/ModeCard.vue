<template>
    <div
        :class="[
            'm-2 p-3 flex flex-col text-white h-[150px] w-[150px] bg-gray-600 shadow-lg rounded-lg hover:scale-105 cursor-pointer transition-transform duration-300 ease-in-out',
            customClass,
        ]"
    >
        <div class="flex flex-1">
            <!-- Card Upper Content -->
            <div class="flex-1">{{ logo }}</div>
            <div class="flex-1">{{ toggleSwitch}}</div>
        </div>
        <div class="flex flex-col flex-1">
            <h2 class="text-1xl">{{ cardName }}</h2>
            <h1 class="text-2xl font-ex">{{ cardState }}</h1>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        customClass:{
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
