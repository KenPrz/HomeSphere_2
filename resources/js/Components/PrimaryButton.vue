<script setup>
defineProps({
    buttonWidth: {
        type: String,
        default: 'w-full',
    },
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        :class="[buttonWidth,'w-full my-2 py-2 px-4 bg-blue-900 text-white rounded-full hover:bg-blue-600 transition duration-300']"
    >
        <slot />
    </button>
</template>


