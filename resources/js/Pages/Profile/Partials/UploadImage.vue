<script setup>
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import { defineProps, defineEmits } from "vue";

const emit = defineEmits(["close"]);

const form = useForm({
    avatar: null,
    success: false,
    errors: {}, // Added errors state
});

const submit = () => {
    if (validateForm()) {
        form.post(route('image.upload'), {
            onFinish: () => {
                form.reset('image');
                close(); // Call the close function here
            },
        });
    }
};
function close() {
    emit("close");
}

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
    <div class="container bg-white">
        <div class="flex flex-col p-5">
            <div class="text-xl font-semibold">
                <h1>Profile Picture</h1>
            </div>
            <div class="flex flex-col items-center">
                <!-- Render the user's image if it exists, or a placeholder if it doesn't -->
                <div v-if="$page.props.auth.user.profile_image" class="mt-4">
                    <img :src="$page.props.auth.user.profile_image" alt="Profile Picture" class="w-40 h-40 rounded-full" />
                </div>
                <div v-else class="mt-4">
                    <img :src="'img-assets/default_avatar.png'" alt="Default Placeholder" class="w-40 h-40 rounded-full" />
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-4" id="image">
                    <input type="file" @input="form.avatar = $event.target.files[0]" class="border p-2 rounded-md" />
                    <button type="submit"
                        class="bg-cyan-900 text-white px-4 py-2 rounded-3xl hover:bg-blue-600 transition duration-300">
                        <span class="text-sm font-light">Upload</span>
                    </button>
                    <InputError class="mt-2" :message="form.errors.avatar" />
                </form>
            </div>
        </div>
    </div>
</template>
<!-- <div class="p-6">
    <form @submit.prevent="submit" class="flex flex-col gap-4" id="image">
        <input type="file" @input="form.avatar = $event.target.files[0]" class="border p-2 rounded-md" />
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">Upload</button>
        <InputError class="mt-2" :message="form.errors.avatar" />
    </form>
</div> -->
