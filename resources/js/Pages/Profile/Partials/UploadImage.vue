<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    avatar: null,
    success: false, // Added success state
});

function submit() {
    form.post(route('image.upload'));
}
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <input type="file" @input="form.avatar = $event.target.files[0]" />
            <button type="submit">Upload</button>
        </form>
    </div>
</template>
