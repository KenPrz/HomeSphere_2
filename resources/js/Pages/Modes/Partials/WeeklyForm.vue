<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    mode_id: Number,
});
const form = useForm({
    mode_id: props.mode_id,
    activation: {
        type: 'schedule',
        repeat: {
            frequency: 'weekly',
            days: [],
            StartTime: '',
            EndTime: '',
        },
    },
});
const submitForm = () => {
    if (form.activation.repeat.days.length == 0) {
        form.errors = 'Please select at least one day.';
        return;
    }
    form.post(route('modes.schedule'), {
        onFinish: () => {
            form.recentlySuccessful = true;
            setTimeout(() => {
                form.recentlySuccessful = false;
            }, 2000);
        },
    });
};
</script>
<template>
    <form id="weekly_form" @submit.prevent="submitForm">
        <label for="StartTime" class="block">
            Start Time:
        </label>
        <input v-model="form.activation.repeat.StartTime" type="time" id="StartTime" name="StartTime" required
            class="w-full p-2 mb-2 border rounded-md">
        <label for="time" class="block">
            End Time:
        </label>
        <input v-model="form.activation.repeat.EndTime" type="time" id="EndTime" name="EndTime" required
            class="w-full p-2 mb-2 border rounded-md">
        <div class="flex flex-col">
            <label for="days" class="block">
                Days:
            </label>
            <div class="flex justify-between">
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="monday" name="monday" value="monday"
                        class="w-[15px] h-[15px] border rounded-md">
                    <label for="monday" class="block">
                        Mon
                    </label>
                </div>
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="tuesday" name="tuesday" value="tuesday"
                        class="w-[15px] h-[15px] border rounded-md">
                    <label for="tuesday" class="block">
                        Tue
                    </label>
                </div>
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="wednesday" name="wednesday"
                        value="wednesday" class="w-[15px] h-[15px] border rounded-md">
                    <label for="wednesday" class="block">
                        Wed
                    </label>
                </div>
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="thursday" name="thursday"
                        value="thursday" class="w-[15px] h-[15px] border rounded-md">
                    <label for="thursday" class="block">
                        Thu
                    </label>
                </div>
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="friday" name="friday" value="friday"
                        class="w-[15px] h-[15px] border rounded-md">
                    <label for="friday" class="block">
                        Fri
                    </label>
                </div>
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="saturday" name="saturday"
                        value="saturday" class="w-[15px] h-[15px] border rounded-md">
                    <label for="saturday" class="block">
                        Sat
                    </label>
                </div>
                <div class="flex flex-col items-center mx-2 my-2">
                    <input v-model="form.activation.repeat.days" type="checkbox" id="sunday" name="sunday" value="sunday"
                        class="w-[15px] h-[15px] border rounded-md">
                    <label for="sunday" class="block">
                        Sun
                    </label>
                </div>
            </div>
            <span v-if="Object.keys(form.errors).length > 0" class="text-red-500 text-sm text-center">
                {{ form.errors }}
            </span>
        </div>
        <button type="submit"
            class="w-full p-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white rounded-md mt-2">
            Save
        </button>
        <div class="text-center">
            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                <p v-if="form.recentlySuccessful" class="text-sm text-green-600 mt-2">Saved.</p>
            </Transition>
        </div>
    </form>
</template>