<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ModeCard from "../Home/Partials/ModeCard.vue";
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 space-y-6 leading-tight">
                Modes
            </h2>
        </template>
        <main>
            <div class="container py-2 mx-8">
                <div class="flex-row">
                    <h1 class="text-3xl font-bold mb-2">
                        List of Modes
                    </h1>
                    <div class="flex">
                        <div class="flex-col">
                            <ModeCard />
                            <ModeCard />
                            <ModeCard />
                        </div>
                        <div class="bg-white rounded-md w-full me-10 p-5">
                            <div class="flex justify-between w-full pb-3 px-1 border-gray-500 border-b-2">
                        <div class="flex items-center">
                            <div class="font-semibold text-xl me-2">
                                ModeName
                            </div>
                            <form>
                                <input class="rounded-md" type="time" id="time1">
                            </form>
                        </div>
                        <div class="flex">
                            <button class="flex items-center justify-center border-gray-500 border rounded-full px-3 mx-2">
                                <img class="h-4 w-auto" :src="'img-assets/vectors/Edit.svg'" />
                                <span>Edit</span>
                            </button>
                            <button class="flex items-center justify-center border-gray-500 border rounded-full px-3">
                                <img class="h-4 w-auto" :src="'img-assets/vectors/add.svg'" />
                                <span>Add</span>
                            </button>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>