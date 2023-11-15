<template>
    <Head title="Profile" />

    <AuthenticatedLayout
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
                    class="lg:flex lg:justify-center lg:items-center bg-white h-5/6 rounded-xl shadow-md p-6 md:p-10 mx-4 md:mx-10"
                >
                    <div class="card lg:w-full">
                        <div class="flex flex-col md:flex-row">
                            <!-- Profile Image Section -->
                            <div class="md:w-1/3">
                                <div
                                    class="flex flex-col items-center justify-center mt-7"
                                >
                                    <h1
                                        class="font-bold lg:text-4xl md:text-3xl text-gray-800 mb-4"
                                    >
                                        My Profile
                                    </h1>
                                            <v-img v-if="$page.props.auth.user.profile_image"
                                                class="rounded-full mx-auto"
                                                width="200"
                                                :aspect-ratio="1"
                                                :src="'storage/' + $page.props.auth.user.profile_image"
                                                cover
                                            ></v-img>
                                            <v-img v-else
                                                class="rounded-full mx-auto"
                                                width="200"
                                                :aspect-ratio="1"
                                                src="/img-assets/default_avatar.png"
                                                cover
                                            ></v-img>
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
                                    <ButtonLarge
                                        @click="openNameEditModal"
                                        label="Name"
                                        :text="capitalizeFirstLetter($page.props.auth.user.firstName) + ' ' + capitalizeFirstLetter($page.props.auth.user.lastName)
                                        "
                                    />
                                    <ButtonLarge
                                        @click="openEmailEditModal"
                                        label="Email"
                                        :text="$page.props.auth.user.email"
                                    />
                                    <ButtonLarge
                                        @click="openPasswordAndSecurityModal"
                                        label="Password and Security"
                                    />
                                </ul>
                            </div>
                            <!-- End User Details Section -->
                        </div>
                        <Modal
                            :maxWidth="'xl'"
                            :show="showNameEditModal"
                            @close="closeNameEditModal"
                        >
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <UpdateProfileInformationForm
                                    :must-verify-email="mustVerifyEmail"
                                    :status="status"
                                    class="max-w-xl"
                                />
                            </div>
                        </Modal>
                        <Modal
                            :show="showEmailEditModal"
                            @close="closeEmailEditModal"
                        >
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <EmailUpdate
                                    :must-verify-email="mustVerifyEmail"
                                    :status="status"
                                    class="max-w-xl"
                                />
                            </div>
                        </Modal>
                        <Modal
                            :show="showPasswordAndSecurityModal"
                            @close="closePasswordAndSecurityModal"
                        >
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <PasswordAndSecurity />
                            </div>
                        </Modal>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
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
        methods:{
            capitalizeFirstLetter(str) {
            if (!str) return "";
            return str.charAt(0).toUpperCase() + str.slice(1);
            },
        }
    }
</script>