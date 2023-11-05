<script setup>
import { defineEmits } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
const props = defineProps({
    homeData: Array,
    required: true
})
const form = useForm({
    homeData: props.homeData,
})
const submit = () => {
    form.post(route('generate.newInviteKey'),
        {
            onSuccess: () =>
                emit('close'),
        }
    )
};
const emit = defineEmits(['close']);
</script>
<template>
    <div class="container mx-auto px-8 py-5">
        <div class="flex flex-col">
            <form @submit.prevent="submit" class="p-4">
                <h1 class="text-xl font-semibold">Generate New Invite Key?</h1>
                <div class="flex justify-center space-x-4 mt-4">
                    <button type="submit" class="w-48 bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded text-white">
                        Yes
                    </button>
                    <button @click="close" class="w-48 bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded text-white">
                        No
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
  
<script>
export default {
    methods: {
        close() {
            this.$emit('close');
        },
    }
}
</script>