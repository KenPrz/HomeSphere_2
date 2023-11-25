<template>
    <div>
        <div
            :class="[
                'm-3 p-3 flex flex-col h-[150px] w-[150px] bg-gray-600 shadow-lg rounded-lg hover:scale-105 cursor-pointer transition duration-500 ease-in-out',
                customClass,
                is_active.data ? 'bg-white text-black' : 'bg-gray-600 text-white',
            ]"
        >
            <div class="flex h-1/4">
                <div class="flex-1">{{ logo }}</div>
                <div class="flex-1">
                    <div class="ms-5 mt-1">
                        <ToggleSwitch v-model="is_active.data" />
                    </div>
                </div>
            </div>
            <div @click="modeSelected(mode,devices)" class="flex flex-col h-3/4 pt-7">
                <h2 class="text-1xl">{{ mode.mode_name }}</h2>
                <h1 class="text-2xl font-ex">{{ is_active.data ? "ON" : "OFF" }}</h1>
            </div>
        </div>
    </div>
</template>

<script setup>
// import { defineEmits } from "vue";
// const emit = defineEmits(["close"]);
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
</script>
<script>
export default {
    props: {
        customClass: {
            type: String,
            required: false,
            default: "",
        },
        logo: {
            type: String,
            default: 'Default'
        },
        mode: {
            type: Object,
            required: true
        },
        devices: {
            type: Array,
            required: true
        }
    },
    data(){
        return{
            is_active: {data: this.mode.is_active}
        }
    },
    methods: {
        modeSelected(data,devices){
            this.$emit('mode-selected',data,devices)
        }
    }
};
</script>
<!-- 
function cancel() {
    emit("close");
}
-->