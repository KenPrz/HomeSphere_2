<template>
    <div class="container p-3">
        <div class="flex flex-col">
            <h1 class="text-center text-lg font-semibold my-2">{{ is_enabled ? 'Disable' : 'Enable' }} this mode?</h1>
            <div class="flex justify-around full">
                <button @click="toggleMode()" class="bg-slate-400 w-1/2 m-1 p-1 rounded-lg hover:bg-slate-200 transition-colors duration-200">Yes</button>
                <button @click="closeModal()" class="bg-slate-400 w-1/2 m-1 p-1 rounded-lg hover:bg-slate-200 transition-colors duration-200">No</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        is_enabled: {
            required: true
        },
        mode_id: {
            type: Number,
            required: true
        }
    },
    methods: {
        closeModal(){
            this.$emit('close');
        },
        toggleMode(){
            this.$inertia.put(route('mode.toggle'), {
                mode_id: this.mode_id,
                is_enabled: !this.is_enabled
            });
            this.$emit('toggle_enabled');
            this.closeModal();
        }
    }
}
</script>