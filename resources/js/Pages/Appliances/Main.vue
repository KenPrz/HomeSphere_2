<template>
    <Head title="Appliances" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Appliances
            </h2>
        </template>
        <main>
                <div class="container">
                    <h1 class= "mx-10 mt-7 py-5 text-3xl font-bold">
                        List of Appliances
                    </h1>

                    <div class="flex-grow mx-10 mt-5 p-3 rounded-lg bg-white">
                        <div class="flex items-center border border-slate-500 py-2 sm:w-1/2 md:w-2/3 lg:w-1/2 xl:w-1/3 h-12 rounded-full text-1xl text-left">
                            <div class="w-full pe-5 flex">
                                <div class="ml-5 self-center">
                                    <img src="img-assets/vectors/search.svg" alt="search">
                                </div>
                                <input id="searchbar" placeholder="Search" class="flex items-center ml-4 text-sm w-96 border-transparent focus:ring-0 focus:border-white" >
                            </div>
                        </div>
                    </div>

                    <div class="mx-10">
                        <Table
                            :tableHeaders="tableHeaders"
                            :tableData="tableData"
                            :maxHeight="maxHeight"
                        />
                    </div>

                    <div class = "flex justify-between items-center">

                        <div class = "flex mx-10 my-7 pl-10 pb-10 text-xs text-left font-">showing 
                            <b class="px-1"> 6 </b> of 
                            <b class="px-1"> 2 </b> entries
                        </div>

                        <div class = "flex mx-10 my-7 pl-10 pb-10 rounded-lg bg-white">
                        </div>
                    </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>
<script setup>
import { ref } from "vue";
import Table from "@/Components/Table.vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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
            maxHeight: "max-h-80",
        };
    },
};
</script>
<style scoped>
</style>