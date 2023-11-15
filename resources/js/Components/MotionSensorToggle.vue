<script setup>
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
</script>
<template>
    <div class="text-xl text-white text-center mb-2">
        Motion Sensor
    </div>
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
                    // Handle the response as needed.

                    console.log(response); //for debugging only remove at prod
                })
                .catch(error => {
                    // Handle the error as needed.

                    console.log(error); //for debugging only remove at prod
                });
        },
    },
}
</script>