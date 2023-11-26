<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from "vue";
const emit = defineEmits(["close"]);
const modeProps = defineProps({
    mode: {
        type: Object,
        required: true
    },
});
const modeForm = useForm({
    mode_id: modeProps.mode.id,
    mode_name: modeProps.mode.mode_name,
});
const submit = () => {
    modeForm.delete(route('modes.delete'), {
        onSuccess: () => close('deleted'),
    });
};

function close(data) {
    emit("close",data);
}
</script>
<template>
    <div class="bg-white p-6 rounded-lg shadow-md w-full">
            <h2 class="text-xl font-semibold mb-4">Delete?</h2>
            <p class="mb-4">Are you sure you want to delete this mode?</p>
            <div class="flex">
                <form class="hover:bg-red-400 hover:text-white transition duration-300 text-center flex-1 text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded-lg me-2" id="new_device_name" @submit.prevent="submit">
                    <button
                    class="w-full"
                        type="submit"
                    >
                        Yes, delete
                    </button>
                </form>
                <button
                        @click="close()"
                        class="flex-1 text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300"
                    >
                        No, cancel
                </button>
            </div>
        </div>
</template>