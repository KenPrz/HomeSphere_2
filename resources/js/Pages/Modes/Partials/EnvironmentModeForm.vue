<script setup>
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    disabled: {
        type: Boolean,
        required: true
    },
    mode: {
        type: Object,
        required: true
    },
    roomsData: {
        type: Array,
        default: null
    },
});
const form = useForm({
    mode_id: props.mode.id,
    activation: {
        type: 'environment',
        value: {
            sensor: '',
            value: '',
            room_id: '',
        },
    },
});
const submitForm = () => {
    form.post(route('modes.environment'), {
        onFinish: () => cancel(),
    });
};
</script>
<template>
    <div class="container">
        <form id="daily_form" @submit.prevent="submitForm">
            <section class="md:ms-4 md:w-3/4">
                <h1 class="text-lg font-medium mb-1">Activate this mode when</h1>
                <div class="flex items-center">
                    <select v-model="form.activation.value.sensor" id="env" name="env" :disabled="props.disabled" required class="w-auto h-auto mb-2 border rounded-md">
                        <option value="temperature">Temperature</option>
                        <option value="humidity">Humidity</option>
                    </select>
                    <h1 class="text-lg mx-2 mb-1">Is</h1>
                    <input v-model="form.activation.value.value" :disabled="disabled" type="number" class="w-full h-auto mb-2 border rounded-md">
                </div>
                <div class="flex flex-col w-full">
                    <h1 class="text-lg">At</h1>
                    <select v-model="form.activation.value.room_id" id="room_list" name="room_list" :disabled="props.disabled" required class="w-full h-auto mb-2 border rounded-md">
                        <option v-for="room in roomsData" :key="room.id" :value="room.id">{{ room.room_name }}</option>
                    </select>
                </div>
                <button :disabled="props.disabled" type="submit" class="w-full p-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white rounded-md mt-2">
                    Save
                </button>
            </section>
        </form>
    </div>
</template>
