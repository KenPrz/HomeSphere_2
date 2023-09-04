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
                                <input id="search" placeholder="Search" class="ms-5 w-full border-0 focus:border-0">
                            </div>
                        </div>
                    </div>



                    <div class="overflow-x-auto mx-10">
                        <div class="min-w-full flex mx-2 mt-5 mb-2 text-base text-left text-white rounded-tl-lg rounded-tr-lg bg-zinc-600">
                            <div class="w-1/5 py-4 pl-6 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Room</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Type</div>
                            <div class="w-1/5 py-4 pl-3 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Appliance</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Name</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Status</div>
                        </div>

                        <div class="min-w-full flex mx-2 mb-2 text-sm text-left text-black bg-white hover:bg-gray-300 cursor-pointer">
                            <div class="w-1/5 py-4 pl-6 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Bathroom</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">light</div>
                            <div class="w-1/5 py-4 pl-3 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">light</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">bathroom light</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">ON</div>
                        </div>
                        <div class="min-w-full flex mx-2 mb-2 text-sm text-left text-black bg-white hover:bg-gray-300 cursor-pointer">
                            <div class="w-1/5 py-4 pl-6 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">Bathroom</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">light</div>
                            <div class="w-1/5 py-4 pl-3 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">light</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">bathroom light</div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">ON</div>
                        </div>
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
