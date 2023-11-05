<script setup>
import { defineEmits } from 'vue';
import { router,useForm } from '@inertiajs/vue3';
const props = defineProps({
    userData:{
        type: Object,
        required: true
    }
})
const form = useForm({
    user:props.userData,
})

const emit = defineEmits(["close"]);
</script>
<template>
    <div class="text-xl font-semibold mx-4 mt-4">
        Are you sure you want to leave this home?
    </div>
    <form @submit.prevent="submit">
        <div class="my-5 mx-4">
            <div class="flex items-center w-full mt-4">
                <button @click="leaveHome(props.userData.user)" type="submit" class="w-full me-2 bg-red-500 hover:bg-red-600 transition-colors duration-200 text-white p-2 rounded-md">
                    Yes, Leave
                </button>
                <button @click="close()" type="submit" class="w-full bg-slate-500 hover:bg-slate-600 transition-colors duration-200 text-white p-2 rounded-md">
                    No, Cancel
                </button>
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        methods:{
            close(){
                this.$emit('close');
            },
            leaveHome(user) {
                this.$inertia.delete(route('settings.leave', { user }), {
                    onSuccess: () => {
                        close();
                    },
                });
            },
        }
    }
</script>