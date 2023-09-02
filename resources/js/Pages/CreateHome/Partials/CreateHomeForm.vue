<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    home_name: '',
    number_of_rooms: '',
});

const submit = () => {
    form.post(route('new_home'), {
        onFinish: () => form.reset('home_name', 'number_of_rooms'),
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
                    id="home_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.home_name"
                    required
                    autofocus
                    autocomplete="home_name"
                />
                <InputError class="mt-2" :message="form.errors.home_name" />
            </div>
            <div class="w-full flex-1">
                <TextInput
                    placeholder="Number of Rooms"
                    id="number_of_rooms"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.number_of_rooms"
                    required
                    autofocus
                    autocomplete="number_of_rooms"
                />
                <InputError class="mt-2" :message="form.errors.number_of_rooms" />
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
