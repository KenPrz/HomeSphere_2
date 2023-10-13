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

const submit = () => {
    form.post(route('join_home'), {
        onFinish: () => form.reset('home_code'),
    });
};
</script>

<template>
    <Head title="Create Home" />
    <div class="flex flex-col justify-center items-start p-5">
        <h2 class="text-3xl py-4 font-semibold">Join a home</h2>
        <form class="w-full" @submit.prevent="submit">
            <div class="flex flex-col w-full h-full">
                <div class="w-full flex-1">
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
                <InputError :message="$page.props.error" class="my-2 ms-2" />
            </div>

            <div class="flex flex-col items-center mt-2">
                <SecondaryButton type="submit" class="w-24" :class="{ 'opacity-25': form.isLoading }" :disabled="form.isLoading">
                    Request Access
                </SecondaryButton>
            </div>
        </form>
    </div>
</template>
