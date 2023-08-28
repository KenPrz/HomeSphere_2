<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>
        <div class="container mx-auto">
            <div
                class="bg-white rounded-xl shadow-md p-6 md:p-10 mx-4 md:mx-10"
            >
                <div class="card">
                    <div class="flex flex-col md:flex-row">
                        <!-- Profile Image Section -->
                        <div class="md:w-1/4">
                            <div
                                class="flex flex-col items-center justify-center"
                            >
                                <h1
                                    class="font-black text-2xl md:text-3xl text-gray-800"
                                >
                                    Profile
                                </h1>
                                <div class="mt-6 md:mt-10">
                                    <ImageContainer
                                        :imageSize="48"
                                        :imageVal="
                                            $page.props.auth.user.profile_image
                                        "
                                    />
                                </div>
                            </div>
                            <div class="mt-5">
                                <DeleteAndUpload />
                            </div>
                        </div>
                        <!-- End Profile Image Section -->
                        <!-- User Details Section -->
                        <div class="md:w-3/4 md:mt-0 mt-6 md:mt-16">
                            <ul class="flex flex-col md:mr-10">
                                <ButtonLarge
                                    @click="openNameEditModal"
                                    label="Name"
                                    :text="
                                        $page.props.auth.user.firstName +
                                        ' ' +
                                        $page.props.auth.user.lastName
                                    "
                                />
                                <ButtonLarge
                                    @click="openEmailEditModal"
                                    label="Email"
                                    :text="$page.props.auth.user.email"
                                />
                                <ButtonLarge
                                    @click="openPasswordEditModal"
                                    label="Password"
                                    text="Update"
                                />
                            </ul>
                        </div>
                        <!-- End User Details Section -->
                    </div>
                    <Modal
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
                        :show="showPasswordEditModal"
                        @close="closePasswordEditModal"
                    >
                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                            <UpdatePasswordForm class="max-w-xl" />
                        </div>
                    </Modal>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import DeleteAndUpload from "./Partials/DeleteAndUpload.vue";
import EmailUpdate from "./Partials/EmailUpdate.vue";
import ButtonLarge from "./Partials/ButtonLarge.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const showEmailEditModal = ref(false);
const showNameEditModal = ref(false);
const showPasswordEditModal = ref(false);

const openEmailEditModal = () => {
    showEmailEditModal.value = true;
};
const closeEmailEditModal = () => {
    showEmailEditModal.value = false;
};

const openPasswordEditModal = () => {
    showPasswordEditModal.value = true;
};
const closePasswordEditModal = () => {
    showPasswordEditModal.value = false;
};

const openNameEditModal = () => {
    showNameEditModal.value = true;
};

const closeNameEditModal = () => {
    showNameEditModal.value = false;
};
</script>
