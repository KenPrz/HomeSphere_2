<script setup>
import ToggleSwitch from './ToggleSwitch.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { defineEmits } from "vue";

const { device } = defineProps({
    device: Object
});

const emit = defineEmits(["close"]);

function cancel() {
    emit("close");
}
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
                    State: <span class="fond-semibold ms-2">
                        <ToggleSwitch v-model:modelValue="device.is_active" />
                    </span>
                </div>
                <SecondaryButton class="mt-4" @click="cancel">
                    <span class="text-sm font-semibold">Close</span>
                </SecondaryButton>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
    props: {
        device: Object,
    },
    methods: {
        submit() {
            axios.post(`/api/device-toggle`, {
                device_id: this.device.id,
                is_active: this.device.is_active,
            })
                .then(response => {
                    // Handle the response as needed.

                    console.log(response);
                })
                .catch(error => {
                    // Handle the error as needed.

                    console.log(error);
                });
        },
    },
    watch: {
        'device.is_active': function () {
            this.submit();
        },
    }
}
</script>


