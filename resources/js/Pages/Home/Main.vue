<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <main class="p-5 mt-10">
            <div class="flex flex-col"> <!--Parent Div-->
                <div class="flex flex-1"><!--Upper Main Div START-->
                    <div class="flex flex-col"><!--Left Upper Main Div-->
                        <div class="Title">
                            <h1 class="text-4xl font-black tracking-wider">Welcome To Dashboard</h1>
                        </div>
                        <div class="flex flex-col">
                            <h2>List of Modes</h2>
                            <div class="flex flex-wrap">
                                <ModeCard />
                                <ModeCard />
                                <ModeCard />
                                <ModeCard />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-1 justify-end"><!--Right Upper Main Div-->
                        <div class="flex items-center w-1/2 flex-col bg-white p-7 rounded-lg shadow-md">
                            <div class="Title mb-2">
                                <h1 class="text-xl font-black tracking-wide">Living Room</h1>
                            </div>
                            <div class="subTitle">
                                <h1 class="text-sm font-light tracking-wide">(2) Appliances</h1>
                            </div>
                            <div class=" mt-5 flex flex-col items-center py-7 border border-gray-500 rounded-2xl w-full">
                                <div class="Title mb-2">
                                    <h1 class="text-xl font-medium tracking-tight">Motion Sensor</h1>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--Upper Main Div END-->

                <div class="flex flex-1"><!--Lower Main Div-->

                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import ModeCard from "@/Pages/Home/Partials/ModeCard.vue";
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
