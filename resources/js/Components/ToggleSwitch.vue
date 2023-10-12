<template>
    <div
        @click="toggle"
        :class="[ modelValue ? 'bg-blue-400' : 'bg-slate-400' ]"
        class="w-12 transition-all duration-500 h-6 flex items-center rounded-full p-1 cursor-pointer"
    >
        <div
            :class="[ modelValue ? 'translate-x-6 bg-white' : 'bg-white' ]"
            class="w-4 h-4 transition-all duration-500 transform  rounded-full shadow-md"
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
