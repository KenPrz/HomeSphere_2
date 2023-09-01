<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    homeName: '',
    numberOfRooms: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Create Home" />
    <div class="flex flex-col justify-center items-start p-5">
    <h2 class="text-3xl py-4 font-black">Create your Home</h2>
    <form class="w-full" @submit.prevent="submit">
        <div class="flex flex-col w-full h-full">
            <div class="w-full flex-1 mb-5">
                <TextInput
                    placeholder="Home Name"
                    id="homeName"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.homeName"
                    required
                    autofocus
                    autocomplete="homeName"
                />
                <InputError class="mt-2" :message="form.errors.homeName" />
            </div>
            <div class="w-full flex-1">
                <TextInput
                    placeholder="Number of Rooms"
                    id="numberOfRooms"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.numberOfRooms"
                    required
                    autofocus
                    autocomplete="numberOfRooms"
                />
                <InputError class="mt-2" :message="form.errors.numberOfRooms" />
            </div>
        </div>

        <div class="flex flex-col items-center mt-10">
            <SecondaryButton type='submit' class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </SecondaryButton>
        </div>
    </form>
</div>

</template>
