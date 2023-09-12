<script setup>
import Table from "@/Components/Table.vue";
import ModeCard from "@/Pages/Home/Partials/ModeCard.vue";
import NavLink from "@/Components/NavLink.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SwiperCard from "@/Pages/Home/Partials/SwiperCard.vue";
import UserList from "@/Pages/Home/Partials/UserList.vue";
import { Head } from "@inertiajs/vue3";
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
            <h2 class="font-semibold text-xl text-gray-800 space-y-6 leading-tight">
                Profile
            </h2>
        </template>
        <main>
            <div class="grid grid-cols-1 md:grid-cols-7 grid-rows-7 gap-2">
                <!-- Left Column -->
                <div class="col-span-1 md:col-span-5 row-span-7">
                    <div class="grid grid-cols-5 grid-rows-7 gap-2">
                        <div class="col-span-5 row-span-4">
                            <div class="Title">
                                <h1 class="text-3xl mb-2 font-bold tracking-wide">
                                    Welcome to {{ $page.props.homeData.home_name }}
                                </h1>
                            </div>
                            <div class="mx-3">
                                <h1 class="text-md font-medium">
                                    List of Modes
                                </h1>
                                <div class="flex flex-wrap">
                                    <ModeCard />
                                    <ModeCard />
                                    <ModeCard />
                                </div>
                            </div>
                        </div>
                        <div class="col-span-5 row-span-3 row-start-5">
                            <div class="mx-3">
                                <h1 class="text-md font-medium">List of Appliances</h1>
                                <Table
                                    :tableHeaders="tableHeaders"
                                    :tableData="tableData"
                                    :maxHeight="maxHeight"
                                />
                                <div class="bg-white rounded-md w-full flex justify-end shadow-sm">
                                    <NavLink :href="route('appliances.index')">
                                        <button
                                            class="bg-zinc-600 hover:bg-zinc-700 text-white font-semibold py-2 my-1 mx-1 px-6 border border-gray-300 rounded-xl"
                                        >
                                            View List of Appliances
                                        </button>
                                    </NavLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-span-1 md:col-span-2 row-span-7 md:col-start-6">
                    <div class="grid grid-cols-2 grid-rows-6 gap-2">
                        <div class="col-span-2 md:col-span-2 row-span-3">
                            <SwiperCard />
                        </div>
                        <div class="col-span-2 md:col-span-2 row-span-3 row-start-4">
                            <div class="flex item-center p-3 my-2 mx-2">
                                <UserList/>
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
