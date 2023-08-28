<template>
    <li
        class="lg:px-16 lg:py-6 flex items-center justify-between mb-2 rounded-lg bg-gray-600 p-4 transition duration-500 hover:bg-gray-700 hover:cursor-pointer"
    >
        <div>
            <span class="text-white text-xl font-bold">{{ label }}</span><br />
            <p class="text-white">
                {{ text }}
            </p>
        </div>
        <div
            id="arrow"
            class="translate-x-0 transform transition duration-500 hover:translate-x-[-15px]"
        >
            <img :src="'/img-assets/vectors/arrow.svg'" alt="arrow" />
        </div>
    </li>
</template>
<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
            default: "Label",
        },
        text: {
            type: String,
            required: true,
            default: null,
        },
    },
};
</script>
