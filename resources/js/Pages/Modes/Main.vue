<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modes from './Partials/Modes.vue';
import CreateFirstMode from "./Partials/CreateFirstMode.vue";
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
            <div class="container">
                <div class="flex-row">
                    <h1 class="text-3xl font-bold mb-2">
                        List of Modes
                    </h1>
                    <div v-if="modes!=null">
                        <Modes
                            :homeData="homeData"
                            :modes="modes"
                            :devices="devices"
                            :roomsData="roomsData"
                        />
                    </div>
                    <div v-else>
                        <div class="w-full">
                            <CreateFirstMode :user="$page.props.auth.user"/>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>
<script>
    export default {
        props: {
            homeData: {
                type: Object,
                required: true
            },
            modes: {
                type: Array,
                default: null
            },
            devices: {
                type: Array,
                default: null
            },
            roomsData: {
                type: Array,
                default: null
            },
        }
    }
</script>