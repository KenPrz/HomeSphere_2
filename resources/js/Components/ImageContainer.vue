<template>
    <div class="w-full flex flex-col items-center justify-center">
        <img :src="imageVal" :alt="imgAlt" :class="imageClass" />
    </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    imageVal: {
        type: String,
        default: "/img-assets/default_avatar.png",
    },
    imageSize: {
        type: Number,
        default: 32, // Default image size in pixels
    },
    imgAlt: {
        type: String,
        default: "img",
    },
});
const imageClass = `w-${props.imageSize} h-${props.imageSize} sm:w-${props.imageSize * 2} sm:h-${props.imageSize * 2} md:w-${props.imageSize * 3} md:h-${props.imageSize * 3} lg:w-${props.imageSize * 4} lg:h-${props.imageSize * 4}`;
</script>
