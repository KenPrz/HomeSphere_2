<script setup>
defineProps({
    buttonWidth: {
        type: String,
        default: 'w-full',
    },
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        :class="[buttonWidth,'mb-3 py-2 px-4 bg-gray-500 text-white rounded-full hover:bg-gray-600 transition duration-300 register-button']"
    >
        <slot />
    </button>
</template>
