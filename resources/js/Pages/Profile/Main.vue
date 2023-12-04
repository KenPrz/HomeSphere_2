<template>
    <Head title="Profile" />

    <AuthenticatedLayout
        :notifications="$page.props.notifications"
        :homeData="$page.props.homeData"
    >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <div class="w-auto lg:h-screen flex justify-center items-center">
            <div class="container mx-auto lg:h-4/6">
                <div
                    class="lg:flex lg:justify-center lg:items-center bg-white h-5/6 rounded-xl shadow-md p-6 md:p-10 mx-4 md:mx-10">
                    <div class="card lg:w-full">
                        <div class="flex flex-col md:flex-row">
                            <!-- Profile Image Section -->
                            <div class="md:w-1/3">
                                <div class="flex flex-col items-center justify-center mt-7">
                                    <h1 class="font-bold lg:text-4xl md:text-3xl text-gray-800 mb-4">
                                        My Profile
                                    </h1>
                                    <v-img v-if="$page.props.auth.user.profile_image" class="rounded-full mx-auto"
                                        width="200" :aspect-ratio="1"
                                        :src="'storage/' + $page.props.auth.user.profile_image" cover></v-img>
                                    <v-img v-else class="rounded-full mx-auto" width="200" :aspect-ratio="1"
                                        src="/img-assets/default_avatar.png" cover></v-img>
                                    <div class="mt-2">
                                        <DeleteAndUpload />
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                            <!-- End Profile Image Section -->
                            <!-- User Details Section -->
                            <div class="md:w-3/4 mt-6 md:mt-16">
                                <ul class="flex flex-col md:mr-10">
                                    <ButtonLarge @click="openNameEditModal" label="Name" :text="capitalizeFirstLetter($page.props.auth.user.firstName) + ' ' + capitalizeFirstLetter($page.props.auth.user.lastName)
                                        " />
                                    <ButtonLarge @click="openEmailEditModal" label="Email"
                                        :text="$page.props.auth.user.email" />
                                    <ButtonLarge @click="openPasswordAndSecurityModal" label="Password and Security" />
                                    <button @click="openLogoutModal"
                                        class="md:hidden w-full h-10 rounded-lg hover:bg-red-600 transition-colors duration-300 bg-red-500 text-white  mb-14">
                                        Logout
                                    </button>
                                </ul>
                            </div>

                        </div>
                        <Modal :maxWidth="'md'" :show="showNameEditModal" @close="closeNameEditModal">
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                                    class="max-w-xl" />
                            </div>
                        </Modal>
                        <Modal :show="showEmailEditModal" @close="closeEmailEditModal">
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <EmailUpdate :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
                            </div>
                        </Modal>
                        <Modal :show="showPasswordAndSecurityModal" @close="closePasswordAndSecurityModal">
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <PasswordAndSecurity />
                            </div>
                        </Modal>

                        <Modal :maxWidth="'sm'" :show="showLogoutModal" @close="closeLogoutModal">
                            <div class="bg-white p-6 rounded-lg shadow-md w-auto">
                                <h2 class="text-xl font-semibold mb-4">Logout?</h2>
                                <p class="mb-4">Are you sure you want to logout?</p>
                                <div class="flex">
                                    <button @click="closeLogoutModal"
                                        class="flex-1 text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-4 hover:bg-gray-400 transition duration-300">
                                        No, cancel
                                    </button>
                                    <Link :href="route('logout')" method="post" as="button"
                                        class="flex-1 text-sm bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                                        Yes, logout
                                    </Link>
                                </div>
                            </div>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteAndUpload from "./Partials/DeleteAndUpload.vue";
import EmailUpdate from "./Partials/EmailUpdate.vue";
import ButtonLarge from "@/Components/ButtonLarge.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
import { Head } from "@inertiajs/vue3";
import PasswordAndSecurity from "./Partials/PasswordAndSecurity.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const showPasswordAndSecurityModal = ref(false);
const showEmailEditModal = ref(false);
const showNameEditModal = ref(false);
const showLogoutModal = ref(false);

const closeLogoutModal = () => {
    showLogoutModal.value = false;
};
const openLogoutModal = () => {
    showLogoutModal.value = true;
};
const closePasswordAndSecurityModal = () => {
    showPasswordAndSecurityModal.value = false;
};
const openPasswordAndSecurityModal = () => {
    showPasswordAndSecurityModal.value = true;
};

const openEmailEditModal = () => {
    showEmailEditModal.value = true;
};
const closeEmailEditModal = () => {
    showEmailEditModal.value = false;
};

const openNameEditModal = () => {
    showNameEditModal.value = true;
};

const closeNameEditModal = () => {
    showNameEditModal.value = false;
};

</script>
<script>
export default {
    methods: {
        capitalizeFirstLetter(str) {
            if (!str) return "";
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
    }
}
</script>