<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import SideCard from "@/Pages/Home/Partials/SideCard.vue";
import Table from "@/Pages/Home/Partials/Table.vue";
import ModeCard from "@/Pages/Home/Partials/ModeCard.vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
const toggleState = ref(false);
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <main class="lg:p-5 lg:ml-5 lg:mt-10">
            <div class="Title">
                <h1 class="text-4xl font-black tracking-wider">
                    Welcome to {{ $page.props.homeData.home_name }}
                </h1>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-6 lg:grid-rows-1">
                <div class="col-span-1 lg:col-span-4">
                    <h2
                        class="text-2xl font-semibold tracking-wide lg:ml-4 lg:mt-10"
                    >
                        List of Modes
                    </h2>
                    <div class="flex flex-wrap">
                        <ModeCard />
                        <ModeCard />
                    </div>
                    <div class="Title">
                        <h2
                            class=" bottom-0 text-2xl font-semibold tracking-wide lg:ml-4 lg:mt-10"
                        >
                            List of Appliances
                        </h2>
                    </div>
                </div>
                <div class="col-span-1 lg:col-span-2 lg:col-start-5">
                    <div class="flex justify-center">
                        <div
                            class="p-6 flex w-11/12 lg:w-9/12 flex-col items-center bg-white shadow-lg rounded-xl"
                        >
                            <h1 class="text-md font-semibold tracking-wide">
                                Living Room
                            </h1>
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
                                    <div
                                        class="flex justify-center items-center w-full h-full"
                                    >
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
                                <div
                                    class="col-span-3 row-span-3 col-start-3 row-start-3"
                                >
                                    <div class="text-xl font-extrabold">
                                        32°
                                    </div>
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-5 grid-rows-5 gap-4 rounded-2xl w-11/12 lg:w-5/6 h-16 border mb-2"
                            >
                                <div class="col-span-2 row-span-5">
                                    <div
                                        class="flex justify-center items-center w-full h-full"
                                    >
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
                                <div
                                    class="col-span-3 row-span-3 col-start-3 row-start-3"
                                >
                                    <div class="text-xl font-extrabold">
                                        60%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-6 lg:grid-rows-1">
                <div class="col-span-1 lg:col-span-4 hidden lg:block">
                    <Table
                        :tableHeaders="tableHeaders"
                        :tableData="tableData"
                        :maxHeight="maxHeight"
                    />
                </div>
                <div
                    class="col-span-1 lg:col-span-2 lg:col-start-5 hidden lg:block"
                >
                    <div class="col-span-2 col-start-5">
                        <div class="flex justify-center">
                            <div
                                class="p-6 mt-10 flex w-9/12 flex-col items-center bg-white shadow-lg rounded-xl"
                            >
                                Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Quos porro dignissimos commodi
                                qui deleniti sed maxime nostrum dolores? Ipsam
                                eaque itaque necessitatibus dolorum et doloribus
                                consectetur aspernatur voluptatem, est
                                laudantium.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script>
export default {
    components: {
        Table,
    },
    data() {
        return {
            tableHeaders: [
                {
                    text: "Room",
                },
                {
                    text: "Type",
                },
                {
                    text: "Appliances",
                },
                {
                    text: "Name",
                },
                {
                    text: "Status",
                },
            ],
            tableData: [
                ["Room 101", "Living Room", "TV, Sofa", "John Doe", "Active"],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
                [
                    "Room 102",
                    "Bedroom",
                    "Bed, Dresser",
                    "Jane Smith",
                    "Inactive",
                ],
            ],
            maxHeight: "max-h-52",
        };
    },
};
</script>
