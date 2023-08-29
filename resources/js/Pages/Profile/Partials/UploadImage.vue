<script setup>
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    avatar: null,
    success: false,
    errors: {}, // Added errors state
});

const submit = () => {
    if (validateForm()) {
        form.post(route('image.upload'), {
            onFinish: () => form.reset('image'),
        });
    }
};

const validateForm = () => {
    form.errors = {}; // Reset previous errors

    const errors = {};

    // Perform manual validation
    if (!form.avatar) {
        
        errors.avatar = ['The avatar field is required.'];
    } else {
        const allowedFormats = ['jpeg', 'png', 'jpg'];
        const maxFileSize = 2048; // Max file size in kilobytes

        const fileExtension = form.avatar.name.split('.').pop().toLowerCase();
        if (!allowedFormats.includes(fileExtension)) {
            errors.avatar = ['Invalid file format. Only JPEG, PNG, and JPG are allowed.'];
        } else if (form.avatar.size / 1024 > maxFileSize) {
            errors.avatar = [`File size exceeds ${maxFileSize} KB.`];
        }
    }
    if (Object.keys(errors).length > 0) {
        form.errors = errors;
        return false;
    }

    return true;
};
</script>

<template>
    <div class="p-6">
        <form @submit.prevent="submit" class="flex flex-col gap-4" id="image">
            <input type="file" @input="form.avatar = $event.target.files[0]" class="border p-2 rounded-md" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Upload</button>
            <InputError class="mt-2" :message="form.errors.avatar" />
        </form>
    </div>
</template>
