<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ModeCard from "../Home/Partials/ModeCard.vue";
import Modal from "@/Components/Modal.vue";
import AddAppliance from "./Partials/AddAppliance.vue";
import Modes from './Partials/Modes.vue';
import EditMode from "./Partials/EditMode.vue";
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
    const showEditModeModal = ref(false);
    const showAddApplianceModal = ref(false);
    const openAddApplianceModal = () => {
        showAddApplianceModal.value = true;
    };
    const closeAddApplianceModal = () => {
        showAddApplianceModal.value = false;
    };
    const openEditModeModal = () => {
        showEditModeModal.value = true;
    };
    const closeEditModeModal = () => {
        showEditModeModal.value = false;
    };
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
            }
        }
    }
</script>