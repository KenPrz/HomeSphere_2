<script setup>
import { ref } from "vue";
import Table from "@/Components/Table.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
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
                            class="bottom-0 text-2xl font-semibold tracking-wide lg:ml-4 lg:mt-10"
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
                        <div class="flex flex-col items-center">
                            <div
                                class="py-4 mt-7 flex w-9/12 flex-col bg-zinc-600 shadow-lg rounded-t-xl"
                            >
                                <h1 class="text-md ps-5 font-bold text-white">
                                    All Users
                                </h1>
                            </div>
                            <div
                                class="py-4 flex w-9/12 flex-col bg-white shadow-lg rounded-b-xl"
                            >
                                <div class="flex mx-5">
                                    <div class="item">
                                        <ImageContainer
                                            :imageSize="14"
                                            :imageVal="
                                                $page.props.auth.user
                                                    .profile_image
                                            "
                                            borderRadius="rounded-md"
                                            pointerType="cursor-pointer"
                                        >
                                        </ImageContainer>
                                    </div>
                                    <div class="ms-6 flex flex-col">
                                        <h1 class="text-xl font-bold">
                                            {{
                                                $page.props.auth.user.firstName.charAt(0).toUpperCase() +
                                                $page.props.auth.user.firstName.slice(1).toLowerCase() +
                                                ' ' +
                                                $page.props.auth.user.lastName.charAt(0).toUpperCase() +
                                                $page.props.auth.user.lastName.slice(1).toLowerCase()
                                            }}
                                            </h1>
                                        <h2 class="text-md font-light">
                                            <span class="text-green-600"
                                                v-if="
                                                    $page.props.auth.user
                                                        .is_online === 1
                                                "
                                                >• online</span
                                            >
                                            <span class="text-slate-500"
                                                v-else="
                                                    $page.props.auth.user
                                                        .is_online === 0
                                                "
                                                >• offline</span
                                            >
                                        </h2>
                                    </div>
                                </div>
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
