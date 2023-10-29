<template>
    <div class="flex flex-col items-center justify-center mt-24">
        <h1 class="text-3xl font-semibold mb-4">Waiting for Verification</h1>
        <p class="text-gray-600 mb-6">
            Your request to be part of the house is pending verification by the homeowner.
        </p>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full w-64">
            <a target="_blank" href="https://github.com/KenPrz/HomeSphere_2/wiki">Read the Documentation</a>
        </button>
        <button @click="confirmDelete()" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-full mt-4 w-64">
            Cancel Request
        </button>
    </div>
    <!-- {{ $page.props }} -->
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";


const form = useForm({
    success: false,
});

function confirmDelete() {
    form.delete(route("cancel.request"));
}
</script>
