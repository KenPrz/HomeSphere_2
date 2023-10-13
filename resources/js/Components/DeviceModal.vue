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
            <div class="text-md font-semibold">
                {{ device.device_name }}
            </div>
            <div class="flex flex-row">
                <div class="flex flex-col">
                    <div class="text-sm font-semibold">
                        Device Type
                    </div>
                    <div class="text-sm">
                        {{ device.device_type }}
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-sm font-semibold">
                        Device Status: {{ device.is_active }}
                    </div>
                    <div class="text-sm">
                        <ToggleSwitch v-model="device.is_active" />
                    </div>
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