<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from "vue";
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
const modeForm = useForm({
    mode_name: '',
});
const emit = defineEmits(["close"]);
const submitForm1 = () => {
    modeForm.post(route('modes.create'), {
        onSuccess: () => close(),
    });
};
function close() {
    emit("close");
}
</script>
<template>
    <div class="container flex flex-col items-center justify-center">
        <h1 class="text-lg font-semibold">{{ title }}</h1>
    </div>
        <form @submit.prevent="submitForm1">
            <TextInput
                id="mode_name"
                class="h-10 font-normal w-full"
                v-model="modeForm.mode_name"
                required
                autocomplete="new mode name"
                autofocus
                :placeHolder="'mode name'"
            />
            <InputError class="mt-1" :message="modeForm.errors.mode_name" />
            <button type="submit" class="w-full mt-2 bg-slate-600 hover:bg-slate-500 transition-colors duration-200 text-white py-2 rounded-lg">
                Create
            </button>
        </form>
</template>
<script>
    export default {
        props: {
            title: {
                type: String,
                default: null
            },
        },
        methods: {
            close() {
                this.$emit('close');
            },
        },
    }
</script>