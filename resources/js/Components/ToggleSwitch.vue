<template>
    <div
        @click="toggle"
        :class="[isDeviceActive ? 'bg-blue-400' : 'bg-slate-400']"
        class="w-9 md:w-10 flex rounded-full p-[3px] cursor-pointer"
    >
        <div
            :class="[isDeviceActive ? 'translate-x-3 md:translate-x-4 lg:translate-x-5 bg-white' : 'bg-white']"
            class="h-4 w-4 transition-all duration-500 transform  rounded-full shadow-md"
        ></div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: [Boolean, Number],
    },
});

const emit = defineEmits(["update:modelValue"]);
const isDeviceActive = ref(props.modelValue);

function toggle() {
    isDeviceActive.value = !isDeviceActive.value;
    emit("update:modelValue", isDeviceActive.value);
}
watch(() => props.modelValue, (newValue) => {
    if (typeof newValue === 'number') {
        isDeviceActive.value = newValue === 1;
    } else if (typeof newValue === 'boolean') {
        isDeviceActive.value = newValue;
    }
});
</script>
