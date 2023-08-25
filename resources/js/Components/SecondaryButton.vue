<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="w-full mb-3 md:w-32 py-2 px-4 bg-gray-500 text-white rounded-full hover:bg-gray-600 transition duration-300 register-button"
    >
        <slot />
    </button>
</template>
