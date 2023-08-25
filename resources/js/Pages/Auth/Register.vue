<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />
    <div class="flex flex-col justify-center items-center p-5">
    <h2 class="text-2xl py-4 font-extrabold">Register</h2>
    <form @submit.prevent="submit">
        <div class="flex w-full">
            <div class="mr-4">
                <InputLabel for="firstName" value="firstName" />
                <TextInput
                    id="firstName"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.firstName"
                    required
                    autofocus
                    autocomplete="firstName"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="lastName" value="lastName" />
                <TextInput
                    id="lastName"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lastName"
                    required
                    autofocus
                    autocomplete="lastName"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
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
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirm Password" />
            <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        <div class="flex flex-col items-center mt-2">
            <SecondaryButton type='submit' class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </SecondaryButton>
        </div>
    </form>
</div>

</template>
