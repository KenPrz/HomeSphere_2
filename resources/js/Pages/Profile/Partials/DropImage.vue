<template>
    <div>
        <button @click="submit">Delete Image</button>
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
</script>
