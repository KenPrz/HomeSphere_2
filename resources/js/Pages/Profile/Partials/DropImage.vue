<template>
        <div class="bg-white p-6 rounded-lg shadow-md w-auto">
            <h2 class="text-xl font-semibold mb-4">Delete Image Confirmation</h2>
            <p class="mb-4">Are you sure you want to delete this image?</p>
            <div class="flex justify-end">
                <button @click="cancel" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-4 hover:bg-gray-400 transition duration-300">Cancel</button>
                <button @click="submit" class="bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">Delete</button>
            </div>
        </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    success: false,
});

function submit() {
    form.delete(route('image.delete'));
}

function cancel() {
    form.reset();
}
</script>