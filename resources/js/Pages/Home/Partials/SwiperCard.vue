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
                    name: "Bathroom",
                    appliances: 2,
                    temperature: "25°C",
                    humidity: "60%",
                    toggleState: ref(false),
                },
                {
                    id: 3,
                    name: "Ken's Room",
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
        :pagination="false"
        :mousewheel="true"
        :keyboard="true"
        :modules="modules"
        class="mySwiper w-full h-full"
    >
        <swiper-slide v-for="room in rooms" :key="room.id">
            <div class="flex flex-col items-center justify-center">
                <div class="w-3/4 mt-5">
                    <div class="title">
                        <div class="text-md font-medium">
                            {{ room.name }}
                        </div>
                        <div class="text-xs mt-1">
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
                                    class="h-6 w-auto"
                                    :src="'/img-assets/vectors/temperature.svg'"
                                    alt=""
                                />
                            </div>
                            <div class="box-child">
                                <div class="text">
                                    <div class="text-sm font-medium">
                                        Temperature
                                    </div>
                                    <div class="text-xs text-start">
                                        {{ room.temperature }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-child-1">
                                <img
                                    class="h-5 w-auto"
                                    :src="'/img-assets/vectors/humidity.svg'"
                                    alt=""
                                />
                            </div>
                            <div class="box-child">
                                <div class="text flex flex-col">
                                    <div class="text-sm font-medium">
                                        Humidity
                                    </div>
                                    <div class="text-xs text-start">
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
.title{
    margin-top: .5em;
    margin-bottom: 3em;
}
.box {
    padding: 0.4em 0 0.3em 0;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    border: 1px solid gray;
    border-radius: 10px;
}
.box img{
    margin-right: .7em;
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
}
</style>
