<script>
import { ref } from "vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";

import "swiper/css/navigation";
import "swiper/css/pagination";

// import required modules
import { Navigation, Pagination, Mousewheel, Keyboard } from "swiper/modules";

export default {
    components: {
        Swiper,
        SwiperSlide,
        ToggleSwitch,
    },
    setup() {
        const toggleState = ref(false);
        return {
            modules: [Navigation, Pagination, Mousewheel, Keyboard],
            rooms: [
                {
                    id: 1,
                    name: "Living Room",
                    appliances: 2,
                    temperature: "25°C",
                    humidity: "60%",
                    toggleState: true,
                },
                {
                    id: 2,
                    name: "Living Room",
                    appliances: 2,
                    temperature: "25°C",
                    humidity: "60%",
                    toggleState: ref(false),
                },
                {
                    id: 1,
                    name: "Living Room",
                    appliances: 2,
                    temperature: "25°C",
                    humidity: "60%",
                    toggleState: ref(false),
                },
            ],
            toggleState,
        };
    },
};
</script>
<template>
    <swiper
        :cssMode="true"
        :navigation="true"
        :pagination="true"
        :mousewheel="true"
        :keyboard="true"
        :modules="modules"
        class="mySwiper"
    >
        <swiper-slide v-for="room in rooms" :key="room.id">
            <div class="flex flex-col items-center justify-center">
                <div class="w-3/4 mt-5">
                    <div class="title">
                        <div class="text-xl font-medium">
                            {{ room.name }}
                        </div>
                        <div class="text-sm mt-1">
                            ({{ room.appliances }}) Appliances
                        </div>
                        <div class="box">
                            <div
                                style="
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    font-size: medium;
                                    margin: 0;
                                    padding: 0;
                                "
                            >
                                <h5>Motion Sensor</h5>
                                <ToggleSwitch v-model="room.toggleState" />
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-child-1">
                                <img
                                    class="h-9 w-auto"
                                    :src="'/img-assets/vectors/temperature.svg'"
                                    alt=""
                                />
                            </div>
                            <div class="box-child">
                                <div class="text">
                                    <div class="text-sm font-medium">
                                        Temperature
                                    </div>
                                    <div class="text-xs">
                                        {{ room.temperature }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-child-1">
                                <img
                                    class="h-9 w-auto"
                                    :src="'/img-assets/vectors/temperature.svg'"
                                    alt=""
                                />
                            </div>
                            <div class="box-child">
                                <div class="text">
                                    <div class="text-sm font-medium">
                                        Humidity
                                    </div>
                                    <div class="text-xs">
                                        {{ room.humidity }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </swiper-slide>
    </swiper>
</template>

<style scoped>
/* Your existing CSS styles can remain as is */
body {
    background: #eee;
    font-size: 14px;
    color: #000;
    margin: 0;
    padding: 0;
}

.swiper {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 80%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    border-radius: 10px;
}

.box {
    padding: 0.7em 0 0.7em 0;
    margin-top: 0.5em;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    border: 1px solid gray;
    border-radius: 10px;
}
.box-child-1 {
    width: 40%;
    height: 100%;
    display: flex;
    justify-content: end;
    align-items: center;
    /* background-color: red; */
}
.box-child {
    width: 60%;
    height: 100%;
    display: flex;
    justify-content: start;
    align-items: center;
}
</style>
