<script setup>
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
</script>
<template>
    <div class="flex items-center justify-center">
        <ToggleSwitch @update:modelValue="submit(!motionSensor.is_active)" v-model="motionSensor.is_active"/>
    </div>
</template>
<script>
export default {
    props: {
        motionSensor: {
            type: Object,
            required: true
        },
        userId: {
            type: Number,
            required: true
        },
        homeId: {
            type: Number,
            required: true
        },
        roomId: {
            type: Number,
            required: true
        }
    },
    methods: {
        submit(data) {
            axios.put(`api/motion-sensor-toggle`, {
                roomId: this.roomId,
                homeId: this.homeId,
                userId: this.userId,
                motionSensorId: this.motionSensor.id,
                is_active: data,
            })
                .then(response => {
                })
                .catch(error => {
                });
        },
    },
}
</script>