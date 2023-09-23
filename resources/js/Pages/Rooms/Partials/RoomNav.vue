<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const baseClasses = "flex w-full items-center mb-2";
const activeClasses = "bg-slate-200 transition-colors duration-500 ease-in-out rounded-md ";
const inactiveClasses = "hover:bg-slate-400 transition-colors duration-500 ease-in-out rounded-lg";

const classes = computed(() => {
    return props.active ? `${baseClasses} ${activeClasses}` : `${baseClasses} ${inactiveClasses}`;
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
