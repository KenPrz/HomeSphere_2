<template>
    <img :src="imageVal" alt="img" class="rounded-full w-32 h-32 mx-auto mb-2" />
</template>
<script setup>
import { defineProps } from "vue";

const props = defineProps({
    imageVal: {
        type: String,
        default: "/img-assets/default_avatar.png",
    },
});
</script>