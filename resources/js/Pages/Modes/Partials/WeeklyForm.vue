<template>
    <form id="weekly_form" @submit.prevent="submitForm">
        <label for="StartTime" class="block">
            Start Time:
        </label>
        <input v-model="form.activation.repeat.StartTime.data" type="time" id="StartTime" name="StartTime" required
            class="w-full p-2 mb-2 border rounded-md">
        <label for="time" class="block">
            End Time:
        </label>
        <input v-model="form.activation.repeat.EndTime.data" type="time" id="EndTime" name="EndTime" required
            class="w-full p-2 mb-2 border rounded-md">
        <div class="flex flex-col">
            <label for="days" class="flex justify-between">
                <div class="flex">
                    
                    Triggered every:
                    <span class="ms-1" v-for="(day, index) in days" :key="index">
                        {{ day.slice(0, 3).charAt(0).toUpperCase() + day.slice(0, 3).slice(1) + ','+' ' }}
                    </span>
                </div>
                <button type="button" class="me-2 text-blue-500 hover:text-blue-600 transition-all duration-200" @click="showEdit">Edit</button>
            </label>
            <div v-if="editDays==true" class="flex justify-between mt-2">
                <div class="flex flex-col items-center" v-for="(day, index) in daysList" :key="index">
                    <input
                        class="rounded-md"
                        type="checkbox"
                        :id="day"
                        :value="day"
                        v-model="form.activation.repeat.days"
                    />
                    <label :for="day">{{ day.slice(0, 3) }}</label>
                </div>
            </div>
            <span v-if="Object.keys(errors).length > 0" class="text-red-500 text-sm text-center">
                {{ errors }}
            </span>
        </div>
        <button type="submit"
            class="w-full p-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 text-white rounded-md mt-2">
            Save
        </button>
        <div class="text-center">
            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                <p v-if="recentlySuccessful" class="text-sm text-green-600 mt-2">Saved.</p>
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
            },
            days: {
                type: Array,
                default: null
            },
            start_time: {
                type: String,
                required: true
            },
            end_time: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                form: {
                    mode_id: this.mode_id,
                    activation:{
                        type: 'schedule',
                        repeat: {
                            frequency: 'weekly',
                            days: [],
                            StartTime: {data: this.start_time},
                            EndTime: {data: this.end_time},
                        },
                    },
                },
                recentlySuccessful: false,
                errors: '',
                editDays: false,
                daysList: ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                selectedDays: []
            }
        },
        methods: {
            showEdit() {
                this.editDays = !this.editDays;
            },
            submitForm() {
                if (this.form.activation.repeat.days.length == 0)
                {
                    this.errors = 'Please select at least one day.';
                    return;
                }else if(this.form.activation.repeat.days.length == 0 && this.editDays == false){
                    this.form.activation.repeat.days = this.days;
                }
                this.$inertia.post(route('modes.schedule'), this.form, {
                    onFinish: () => {
                        this.recentlySuccessful = true;
                        this.editDays = false;
                        setTimeout(() => {
                            this.recentlySuccessful = false;
                            this.errors = '';
                        }, 2000);
                    },
                });
            },
        },
        watch: {
            'mode_id': function() {
                this.form.mode_id = this.mode_id;
                this.form.activation.repeat.StartTime.data = this.start_time;
                this.form.activation.repeat.EndTime.data = this.end_time;
                this.selectedDays = this.days;
                this.form.activation.repeat.days = this.selectedDays;
            },
        }
    }
</script>