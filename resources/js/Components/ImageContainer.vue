<template>
    <img :src="imageVal" alt="img" class="max-w-full h-auto mx-auto" />
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
    imageVal: {
        type: String,
        default: "https://via.placeholder.com/150",
    },
});
</script>