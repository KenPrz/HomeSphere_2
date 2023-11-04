<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    roomID:{
        type: Number,
        required: true
    }
})


const emit = defineEmits(["close"]);

const form = useForm({
    roomName: '',
    room_id: props.roomID,
});

const submit = () => {
    form.post(route('rooms.edit'),
        {
            onSuccess: () =>
                emit('close'),
        }
    )
};
</script>
<template>
    <div class="text-xl font-semibold mx-4 mt-4">
        Edit Room
    </div>
    <form @submit.prevent="submit">
        <div class="my-5 mx-4">
            <div class="my-3">
                <InputLabel for="roomName" value="Edit Room Name" />
                <TextInput id="roomName" type="text" class="mt-1 block w-full" v-model="form.roomName" required autofocus
                    autocomplete="roomName" />
                <InputError class="mt-2" :message="form.errors.roomName" />
            </div>
            <div class="flex flex-col items-center w-full mt-4">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Change Room Name
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        methods:{
            close() {
                this.$emit('close');
            },
        }
    }
</script>