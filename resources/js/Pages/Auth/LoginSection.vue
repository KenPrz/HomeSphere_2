<template>
    <div class="w-full md:w-1/2 flex justify-center mt-4 md:mt-0">
        <div class="bg-white p-10 m-4 md:m-6 rounded-lg shadow-lg w-full">
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>
            <h2 class="text-2xl py-4 font-semibold">Login</h2>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                    
                <div class="flex justify-between mt-4">
                    
                    <div class="flex items-center w-full">
                        <Checkbox
                            name="remember"
                            v-model:checked="form.remember"
                        />
                        <span class="ml-2 text-sm text-gray-600"
                            >Remember me</span
                        >
                    </div>
                    <ResetPasswordModal/>
                </div>

                <div class="flex flex-col items-center w-full mt-4">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Log in
                    </PrimaryButton>
                </div>
            </form>
            <div class="flex w-full items-center justify-center">
                <div class="border-b border-gray-300 w-full mt-4 mb-4"></div>
                <div class="text-gray-500 mx-4">OR</div>
                <div class="border-b border-gray-300 w-full mt-4 mb-4"></div>
            </div>
            <RegisterModal/>
        </div>
    </div>
</template>
<script setup>
import ResetPasswordModal from "@/Pages/Auth/ResetPasswordModal.vue";
import Modal from "@/Components/Modal.vue";
import RegisterModal from "@/Pages/Auth/RegisterModal.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
    status: {
        type: String,
    },
});
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>
