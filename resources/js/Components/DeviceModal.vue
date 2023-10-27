<script setup>
    import ToggleSwitch from './ToggleSwitch.vue';
    defineProps({
        device: {
            type: Object,
        },
    });
</script>
<template>
    <div class="container">
        <div class="flex flex-col">
            <div class="text-xl text-center font-semibold">
                {{ device.device_name }}
            </div>
            <div class="text-md">
                <div class="font md">
                    Type: <span class="fond-semibold">{{ device.device_type }}</span>
                </div>
                
                <div class="font md">
                    Room: <span class="fond-semibold">{{ device.room_name }}</span>
                </div>
                
                <div class="font md flex">
                    State:  <span class="fond-semibold ms-2">
                                <ToggleSwitch v-model:modelValue="device.is_active"/>
                                {{ device.is_active }}
                            </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        components: {
            ToggleSwitch,
        },
    };
</script>