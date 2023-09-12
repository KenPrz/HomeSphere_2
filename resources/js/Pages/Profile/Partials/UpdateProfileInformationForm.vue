<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    firstName: user.firstName,
    lastName: user.lastName,
    email: user.email,
});
</script>

<template>
    <section>
        <div class="mx-10">
            <header>
                <h2 class="text-2xl font-black font-medium text-gray-900">Name</h2>

                <p class="mt-1 text-md text-gray-600">
                    If you change your name, you can't change it again for 60 days. Don't add any unusual capitalization, punctuation, characters or random words.
                </p>
            </header>

            <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
                <div>
                    <InputLabel for="firstName" value="First Name" />

                    <TextInput
                        id="firstName"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.firstName"
                        required
                        autofocus
                        autocomplete="firstName"
                    />

                    <InputError class="mt-2" :message="form.errors.firstName" />
                </div>
                <div>
                    <InputLabel for="lastName" value="Last Name" />

                    <TextInput
                        id="lastName"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.lastName"
                        required
                        autofocus
                        autocomplete="lastName"
                    />

                    <InputError class="mt-2" :message="form.errors.lastName" />
                </div>
                <div class="flex flex-col items-center gap-4 w-full">
                    <PrimaryButton
                    :disabled="form.processing">Change Name</PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </section>
</template>
