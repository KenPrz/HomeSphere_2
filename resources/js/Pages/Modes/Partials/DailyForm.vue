<template>
    <form id="daily_form" @submit.prevent="submitForm">
        <label for="StartTime" class="block">
            Start Time:
        </label>
        <input :disabled="disabled" v-model="form.activation.repeat.StartTime" type="time" id="StartTime" name="StartTime" required class="w-full p-2 mb-2 border rounded-md">
        <label for="time" class="block">
            End Time:
        </label>
        <input :disabled="disabled" v-model="form.activation.repeat.EndTime" type="time" id="EndTime" name="EndTime" required class="w-full p-2 mb-2 border rounded-md">
        <button :disabled="disabled" type="submit" class="w-full p-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white rounded-md mt-2">
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
<script>
    export default {
        props: {
            mode_id: {
                type: Number,
                required: true
            },
            disabled: {
                type: Boolean,
                required: true
            }
        },
        data() {
            return {
                form: {
                    mode_id: this.mode_id,
                    activation:{
                        type: 'schedule',
                        repeat: {
                            frequency: 'daily',
                            StartTime: '',
                            EndTime: '',
                        },
                    },
                },
                recentlySuccessful: false,
            }
        },
        methods: {
            submitForm() {
                this.$inertia.post(route('modes.schedule'), this.form, {
                    onSuccess: () => {
                        this.recentlySuccessful = true;
                        setTimeout(() => {
                            this.recentlySuccessful = false;
                        }, 2000);
                    },
                });
            },
        },
        watch: {
            mode_id: function(){
                this.form.mode_id=this.mode_id;
            }
        }
    }
</script>