<script setup>
import { computed } from 'vue';
const props = defineProps({
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex justify-center items-center rounded-2xl w-auto px-6 bg-zinc-600 text-white mx-1 inline-flex items-center px-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
        : 'flex justify-center items-center rounded-2xl w-auto px-6 bg-zinc-50 text-zinc-600 mx-1 inline-flex items-center px-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
);
</script>
<template>
    <button :class="classes">
        <slot />
    </button>
</template>