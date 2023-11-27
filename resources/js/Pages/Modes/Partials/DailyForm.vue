<script setup>
    import {useForm}  from '@inertiajs/vue3';
    const props = defineProps({
        mode_id: Number,
        disabled: Boolean,
    });
    const form = useForm({
        mode_id: props.mode_id,
        activation:{
            type: 'schedule',
            repeat: {
                frequency: 'daily',
                StartTime: '',
                EndTime: '',
            },
        },
    });
    const submitForm = () => {
        form.post(route('modes.schedule'), {
            onFinish: () => cancel(),
        });
    };
</script>
<template>
    <form id="daily_form" @submit.prevent="submitForm">
        <label for="StartTime" class="block">
            Start Time:
        </label>
        <input :disabled="props.disabled" v-model="form.activation.repeat.StartTime" type="time" id="StartTime" name="StartTime" required class="w-full p-2 mb-2 border rounded-md">
        <label for="time" class="block">
            End Time:
        </label>
        <input :disabled="props.disabled" v-model="form.activation.repeat.EndTime" type="time" id="EndTime" name="EndTime" required class="w-full p-2 mb-2 border rounded-md">
        <button :disabled="props.disabled" type="submit" class="w-full p-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white rounded-md mt-2">
            Save
        </button>
    </form>
</template>