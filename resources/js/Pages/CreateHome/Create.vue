<template>
        <Head title="Create Home" />
        <TopNav
                :user="$page.props.auth.user"
                :notifications="notifications"
            />
    <main class="flex items-center justify-center w-full h-screen bg-gray-100">
        <div class="bg-white p-8 w-8/12 rounded-lg shadow-md mx-auto">
            <div class="mt-9 text-2xl sm:text-2xl md:text-4xl lg:text-5xl font-semibold text-black text-center">
                Start Your Home Automation Journey
            </div>
            <div class="my-1 sm:my-3 md:my-4 lg:my-7 text-lg sm:text-xl md:text-2xl lg:text-3xl font-medium text-black text-center">
                Choose Your Home Setup Option
            </div>
            <div class="flex flex-col md:flex-row w-full h-48 my-5">
                <a
                    @click="openCreateHomeModal"
                    class="sm:h-12 md:h-32 lg:h-44 child flex-1 bg-green-500 m-2 rounded-3xl transition-colors duration-200 hover:bg-green-400 cursor-pointer"
                >
                    <div class="h-full w-full flex items-center justify-center">
                        <h1 class="md:text-xl lg:text-2xl text-white font-semibold mr-4">
                            Create Home
                        </h1>
                        <img
                            class="h-4 sm:h-8 lg:h-12 w-auto"
                            :src="'/img-assets/vectors/House.svg'"
                            alt="test"
                        />
                    </div>
                </a>
                <a
                    @click="openJoinHomeModal"
                    class="sm:h-12 md:h-32 lg:h-44 child flex-1 bg-blue-900 m-2 rounded-3xl transition-colors duration-200 hover:bg-blue-600 cursor-pointer"
                >
                <div class="h-full w-full flex items-center justify-center">
                        <h1 class="md:text-xl lg:text-2xl text-white font-semibold mr-4">
                            Join Home
                        </h1>
                        <img
                            class="h-4 sm:h-8 lg:h-12 w-auto"
                            :src="'/img-assets/vectors/join_home.svg'"
                            alt="test"
                        />
                    </div>
                </a>
            </div>

            <div class="text-center">
                <span class="text-md font-semibold text-black">Not Sure? </span>
                <span
                    class="text-md font-semibold text-blue-600 hover:underline cursor-pointer transition duration-300 ease-in-out"
                    ><a href="https://github.com/KenPrz/HomeSphere_2/wiki" target="_blank">Learn More</a></span
                >
            </div>
        </div>
        <Modal :show="showCreateHomeModal" @close="closeCreateHomeModal">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <CreateHomeForm />
            </div>
        </Modal>
        <Modal :show="showJoinHomeModal" @close="closeJoinHomeModal">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <JoinHomeForm />
            </div>
        </Modal>
    </main>
</template>

<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import TopNav from "@/Layouts/TopNav.vue";
import Modal from "@/Components/Modal.vue";
import CreateHomeForm from "./Partials/CreateHomeForm.vue";
import JoinHomeForm from "./Partials/JoinHomeForm.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    notifications: {
        type: Array,
        default: null,
    },
});

const showCreateHomeModal = ref(false);
const showJoinHomeModal = ref(false);

const openCreateHomeModal = () => {
    showCreateHomeModal.value = true;
};

const closeCreateHomeModal = () => {
    showCreateHomeModal.value = false;
};

const openJoinHomeModal = () => {
    showJoinHomeModal.value = true;
};

const closeJoinHomeModal = () => {
    showJoinHomeModal.value = false;
};
</script>

<style scoped></style>
