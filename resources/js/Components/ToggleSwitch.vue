<template>
    <div
        @click="toggle"
        class="w-14 transition-all duration-500 h-8 flex bg-slate-400 items-center rounded-full p-1 cursor-pointer"
    >
        <div
            :class="{ 'translate-x-6 bg-green-500': modelValue }"
            class="w-6 h-6 transition-all duration-500 transform bg-white rounded-full shadow-md"
        ></div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    modelValue: {
        type: Boolean,
    },
});

const emit = defineEmits(["update:modelValue"]);

function toggle() {
    emit("update:modelValue", !props.modelValue);
}
</script>
