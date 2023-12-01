<script setup>
import ToggleSwitch from '@/Components/ToggleSwitch.vue';
import ScheduleModeForm from './ScheduleModeForm.vue';
import EnvironmentModeForm from './EnvironmentModeForm.vue';
</script>
<template>
    <div class="container flex flex-col items-center ">
        <section class="w-full flex flex-col items-center">
            <h1 class="text-xl font-semibold">Select Your Activation Type</h1>

            <section class="w-full flex justify-center p-3 mt-2">
                <h1 :class="[!activatedBy ? 'text-blue-400 font-semibold me-2 duration-500 ease-in-out text-md': 'me-2 text-md font-semibold text-md']">Schedule</h1>
                <ToggleSwitch v-model="activatedBy"/>
                <h1 :class="[activatedBy ? 'text-blue-400 font-semibold ms-2 duration-500 ease-in-out text-md': 'ms-2 text-md font-semibold text-md']">Environment</h1>
            </section>
            <section class="w-full md:flex justify-center items-center p-5">
                <div :class="[!activatedBy ? 'scale-105 duration-500 ease-in-out' : 'hidden md:block scale-95 duration-500 ease-in-out blur-sm']" class="md:w-1/2 p-5">
                    <ScheduleModeForm :disabled="activatedBy" :mode="mode"/>
                </div>
                <div :class="[activatedBy ? 'scale-105 duration-500 ease-in-out' : 'hidden md:block scale-95 duration-500 ease-in-out blur-sm']" class="md:w-1/2 p-5">
                    <EnvironmentModeForm :roomsData="roomsData" :disabled="!activatedBy" :mode="mode"/>
                </div>
            </section>
        </section>
    </div>
</template>
<script>
export default {
    props: {
        mode: {
            type: Object,
            required: true
        },
        roomsData: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            activatedBy: false,
        }
    },
    mounted() {
        if(this.mode.activation_type=='environment')
        {
            this.activatedBy=true;
        }
        else if(this.mode.activation_type=='schedule')
        {
            this.activatedBy=false;
        }
        else{
            this.activatedBy=false;
        }
    },
    watch: {
        'mode.activation_type' : function(){
            if(this.mode.activation_type=='environment')
            {
                this.activatedBy=true;
            }
            else if(this.mode.activation_type=='schedule')
            {
                this.activatedBy=false;
            }
            else{
                this.activatedBy=false;
            }
        }
    },
}
</script>