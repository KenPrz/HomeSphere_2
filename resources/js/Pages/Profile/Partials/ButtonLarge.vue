<template>
    <li class="lg:px-16 lg:py-6 flex items-center justify-between mb-2 rounded-lg bg-gray-600 p-4 transition duration-500 hover:bg-gray-700 hover:cursor-pointer lg:hover:translate-x-[-12px]">
    <div>
        <span class="text-white text-1xl font-bold">{{ label }}</span><br />
        <p class="text-md text-white">{{ text }}</p>
    </div>
    <div id="arrow" class="transform transition duration-500">
        <img class="h-full w-auto" :src="'/img-assets/vectors/arrow.svg'" alt="arrow" />
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
