<script setup>
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import {ref} from 'vue';

const mode_name = ref('');
const emit = defineEmits(["close"]);
const props = defineProps({
    mode_id: {
        type: Number,
        required: true,
    }
});
const form = useForm({
    mode_id: props.mode_id,
    mode_name: '',
});

const submit = () => {
    mode_name.value = form.mode_name;
    form.patch(route('modes.edit'), {
        onSuccess: () => {
            form.reset('mode_name'),
            close(mode_name.value);
        }
    });
};
function close(data) {
    emit("close", data);
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
