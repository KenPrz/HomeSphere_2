<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
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
            <div class="text-center text-2xl font-bold">
                <h1>Profile Picture</h1>
            </div>
            <div class="flex flex-col items-center">
                <div v-if="!imagePreview">
                    <div v-if="$page.props.auth.user.profile_image">
                        <v-img 
                            class="rounded-full mx-auto"
                            width="300"
                            :aspect-ratio="1"
                            :src="`storage/${$page.props.auth.user.profile_image}`"
                            cover
                            >
                        </v-img>
                    </div>
                    <div v-else>
                        <v-img 
                            class="rounded-full mx-auto"
                            width="300"
                            :aspect-ratio="1"
                            :src="`img-assets/default_avatar.png`"
                            cover
                            >
                        </v-img>
                    </div>
                </div>
                <form @submit.prevent="submit" class="flex flex-col gap-4" id="image">
                    <div class="mt-2" v-if="imagePreview">
                        <v-img 
                            class="rounded-full mx-auto"
                            width="300"
                            :aspect-ratio="1"
                            :src="imagePreview"
                            cover
                        >
                        </v-img>
                    </div>
                    <input type="file" @change="onFileChange" class="border p-2 rounded-md">
                    <button type="submit"
                        class="bg-cyan-900 text-white px-4 py-2 rounded-3xl hover:bg-blue-600 transition duration-300">
                        <span class="text-md font-medium">Upload</span>
                    </button>
                    <InputError class="mt-2" :message="form.errors.avatar" />
                </form>
            </div>
        </div>
    </div>
</template>