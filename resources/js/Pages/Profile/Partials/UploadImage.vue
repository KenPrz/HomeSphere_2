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
    <div class="p-6">
        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <input type="file" @input="form.avatar = $event.target.files[0]" class="border p-2 rounded-md" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Upload</button>
        </form>
    </div>
</template>

