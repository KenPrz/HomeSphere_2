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
        ? 'flex justify-center items-center rounded-2xl w-auto px-4 bg-zinc-700 text-white border-2 border-zinc-700 mx-1'
        : 'flex justify-center items-center rounded-2xl w-auto px-4 bg-white text-zinc-700 border-2 border-zinc-700 mx-1'
    );

</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
