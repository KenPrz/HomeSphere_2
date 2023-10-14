<template>
    <div class="w-full flex flex-col items-center justify-center sm:flex-row lg:flex-row">
        <img v-if="imageVal" :src="`storage/${imageVal}`" :alt="imgAlt" :class="imageClass" />
        <img v-else :src="defaultAvatar" :alt="imgAlt" :class="imageClass" />
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    imageVal: {
        type: String,
        default: null,
    },
    imageSize: {
        type: Number,
        default: 32,
    },
    imgAlt: {
        type: String,
        default: "img",
    },
    borderRadius: {
        type: String,
        default: "rounded-md",
    },
    pointerType: {
        type: String,
        default: "cursor-default",
    },
    borderRadius: {
        type: String,
        default: "rounded-md",
    },
    border: {
        type: String,
        default: "",
    },
});

const imageClass = `${props.border} ${props.pointerType} ${props.borderRadius} w-${props.imageSize} h-${props.imageSize} sm:w-${props.imageSize * 2} sm:h-${props.imageSize * 2} md:w-${props.imageSize * 3} md:h-${props.imageSize * 3} lg:w-${props.imageSize * 4} lg:h-${props.imageSize * 4}`;
const defaultAvatar = "/img-assets/default_avatar.png"; // Define the default avatar URL

</script>