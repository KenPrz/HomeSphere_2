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
            trigger_sensor: '',
            threshold:'',
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
                <h1 class="md:text-lg font-medium mb-1">Activate this mode when</h1>
                <div class="flex">
                    <select v-model="form.activation.value.trigger_sensor" id="env" name="env" :disabled="props.disabled" required class="w-full h-auto mb-2 border rounded-md">
                        <option value="temperature">Temperature</option>
                        <option value="humidity">Humidity</option>
                    </select>
                </div>
                <div class="flex">
                    <select v-model="form.activation.value.threshold" id="env" name="env" :disabled="props.disabled" required class="w-3/4 h-auto me-2 mb-2 border rounded-md">
                        <option value="above">Is Above</option>
                        <option value="below">Is Below</option>
                        <option value="specifically">Just Specifically</option>
                    </select>
                    <input :placeholder="mode.value" v-model="form.activation.value.value" type="number" step="0.1" id="value" name="value" :disabled="props.disabled" required class="w-1/4 h-auto mb-2 border rounded-md">
                </div>
                <div class="flex flex-col w-full">
                    <h1 class="text-lg">On</h1>
                    <select v-model="form.activation.value.room_id" id="room_list" name="room_list" :disabled="props.disabled" required class="w-full h-auto mb-2 border rounded-md">
                        <option value="room name" placeholder="Room Name" disabled>Room Name</option>
                        <option v-for="room in roomsData" :key="room.id" :value="room.id">{{ room.room_name }}</option>
                    </select>
                </div>
                <button :disabled="props.disabled" type="submit" class="w-full p-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white rounded-md mt-2">
                    Save
                </button>
                <div class="text-center">
                    <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                        <p v-if="form.recentlySuccessful" class="text-sm text-green-600 mt-2">Saved.</p>
                    </Transition>
                </div>
            </section>
        </form>
    </div>
</template>
