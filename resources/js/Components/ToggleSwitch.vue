<template>
    <div
        @click="toggle"
        :class="[isDeviceActive ? 'bg-blue-400' : 'bg-slate-400']"
        class="w-7 sm:w-8 md:w-10 lg:w-12 transition-all duration-500 h-[20px] sm:h-5 md:h-6 flex items-center rounded-full p-1 cursor-pointer"
    >
        <div
            :class="[isDeviceActive ? 'translate-x-2 md:translate-x-4 lg:translate-x-6 bg-white' : 'bg-white']"
            class="w-3 h-3 sm:w-4 sm:h-4 transition-all duration-500 transform  rounded-full shadow-md"
        ></div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: [Boolean, Number], // Accept both Boolean and Number types
    },
});

const emit = defineEmits(["update:modelValue"]);

// Convert is_active to a Boolean using a computed property
const isDeviceActive = ref(props.modelValue);

function toggle() {
    isDeviceActive.value = !isDeviceActive.value;
    emit("update:modelValue", isDeviceActive.value);
}

// Watch for changes in the modelValue prop and handle both numbers and booleans
watch(() => props.modelValue, (newValue) => {
    if (typeof newValue === 'number') {
        isDeviceActive.value = newValue === 1;
    } else if (typeof newValue === 'boolean') {
        isDeviceActive.value = newValue;
    }
});
</script>
