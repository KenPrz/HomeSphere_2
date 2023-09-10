<script setup>
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    home_code: '',
    error: null,
    isLoading: false,
});

const submit = async () => {
    form.isLoading = true;
    form.error = null; 

    try {
        const response = await form.post(route('join_home'));

        // Check if the response indicates success (you can customize this based on your API response structure)
        if (response.status === 'success') {
            // Do something on success, e.g., reset the form
            form.reset('home_code');
        } else {
            // Handle server-side errors
            form.error = response.message; // Assuming your Laravel response has a 'message' field
        }
    } catch (error) {

        form.error = 'Invalid home code. Please try again.';
    } finally {
        form.isLoading = false; // Set loading state back to false, whether the request was successful or not
    }
};
</script>

<template>
    <Head title="Create Home" />
    <div class="flex flex-col justify-center items-start p-5">
        <h2 class="text-3xl py-4 font-semibold">Join a home</h2>
        <form class="w-full" @submit.prevent="submit">
            <div class="flex flex-col w-full h-full">
                <div class="w-full flex-1 mb-5">
                    <TextInput
                        placeholder="Enter your home code"
                        id="home_code"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.home_code"
                        required
                        autofocus
                        autocomplete="home_code"
                    />
                </div>
            </div>

            <div class="flex flex-col items-center">
                <SecondaryButton type="submit" class="w-24" :class="{ 'opacity-25': form.isLoading }" :disabled="form.isLoading">
                    Request Access
                </SecondaryButton>
            </div>

            <!-- Display server-side errors, if any -->
            <div v-if="form.error" class="text-red-500 mt-2 text-center">{{ form.error }}</div>
        </form>
    </div>
</template>
