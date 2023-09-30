<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'flex justify-center items-center rounded-2xl w-auto px-6 bg-zinc-600 text-white mx-1 inline-flex items-center px-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
        : 'flex justify-center items-center rounded-2xl w-auto px-6 bg-zinc-500 text-white mx-1 inline-flex items-center px-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out'
);

</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
