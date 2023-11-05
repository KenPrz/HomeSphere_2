<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';
// import { router } from '@inertiajs/inertia-vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    homeID:{
        type: Number,
        required: true
    }
})
const emit = defineEmits(["close"]);
const form = useForm({
    homeID:props.homeID,
    password: '',
    password_confirmation: '',
});
const submit = () => {
    form.delete(route('home.delete'), 
        {
            onSuccess: () =>
                this.close()
        }
    )
};
</script>
<template>
    <div class="text-xl font-semibold mx-4 mt-4">
        Are you sure you want to delete your home?
    </div>
    <form @submit.prevent="submit">
        <div class="my-5 mx-4">
            <div class="my-3">
                <InputLabel for="password" value="Your Current Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autofocus
                    autocomplete="password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="my-3">
                <InputLabel for="password_confirmation" value="Re-Type Password" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autofocus
                    autocomplete="password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
            <div class="flex flex-col items-center w-full mt-4">
                <Button type="submit" class="w-full bg-red-500 hover:bg-red-600 transition-colors duration-200 text-white p-2 rounded-md">
                    Delete my home
                </Button>
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