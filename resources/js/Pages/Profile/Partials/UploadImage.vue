<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
import { defineEmits } from "vue";

const emit = defineEmits(["close"]);

const form = useForm({
    avatar: null,
    success: false,
    errors: {},
});

const imagePreview = ref(null);

const submit = () => {
    if (validateForm()) {
        form.post(route("image.upload"), {
            onFinish: () => {
                form.reset("avatar");
                close();
                imagePreview.value = null;
            },
        });
    }
};

function close() {
    emit("close");
}

const onFileChange = () => {
    const file = event.target.files[0];
    form.avatar = file;
    imagePreview.value = URL.createObjectURL(file);
};

const validateForm = () => {
    form.errors = {};

    const errors = {};

    if (!form.avatar) {
        errors.avatar = ["The avatar field is required."];
    } else {
        const allowedFormats = ["jpeg", "png", "jpg"];
        const maxFileSize = 2048;

        const fileExtension = form.avatar.name.split(".").pop().toLowerCase();
        if (!allowedFormats.includes(fileExtension)) {
            errors.avatar = ["Invalid file format. Only JPEG, PNG, and JPG are allowed."];
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
                <div v-if="!imagePreview">
                    <ImageContainer :imageSize="24" :imageVal="$page.props.auth.user.profile_image"
                        borderRadius="rounded-full" pointerType="cursor-pointer"></ImageContainer>
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-4" id="image">
                    <div class="mt-2" v-if="imagePreview">
                        <div class="flex flex-col items-center">
                            <img :src="imagePreview" alt="Selected Image" class="rounded-full w-24 h-24" />
                        </div>
                    </div>
                    <input type="file" @change="onFileChange" class="border p-2 rounded-md" />
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