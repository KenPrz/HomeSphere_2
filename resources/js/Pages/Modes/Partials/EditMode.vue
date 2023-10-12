<script setup>
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const emit = defineEmits(["close"]);

const form = useForm({
    mode_name: '',
});

const submit = () => {
    form.post(route('modes.editMode'), {
        onFinish: () => {
            form.reset('mode_name'),
            close();
        }
    });
};
function close() {
    emit("close");
}
</script>

<template>
    <Head title="Edit Mode" />
    <div class="flex flex-col justify-center items-start p-5">
    <h2 class="text-2xl py-4 font-semibold">Edit Mode</h2>
    <form class="w-full" @submit.prevent="submit">
        <div class="flex flex-col w-full h-full">
            <div class="w-full flex-1 mb-1">
                <TextInput
                    placeholder="Mode Name"
                    id="mode_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.mode_name"
                    required
                    autofocus
                    autocomplete="mode_name"
                />
                <InputError class="mt-2" :message="form.errors.mode_name" />
            </div>
        </div>

        <div class="flex flex-col items-center mt-5">
            <SecondaryButton type='submit'  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update Mode
            </SecondaryButton>
        </div>
    </form>
</div>

</template>
