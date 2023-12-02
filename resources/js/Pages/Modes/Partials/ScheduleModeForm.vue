<script setup>
    import DailyForm from './DailyForm.vue';
    import WeeklyForm from './WeeklyForm.vue';
</script>
<template>
    <span class="text-lg font-medium">Schedule {{ repeat.data  }}</span>
        <label for="repeat" class="block">Repeat</label>
        <select v-model="repeat.data" id="repeat" name="repeat" :disabled="disabled" required class="w-full p-2 mb-2 border rounded-md">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
        </select>
        <section v-if="repeat.data=='daily'">
            <DailyForm 
                :end_time="mode.end_time" 
                :start_time="mode.start_time" 
                :mode_id="mode.id" 
                :disabled="disabled"
            />
        </section>
        <section v-if="repeat.data=='weekly'">
            <WeeklyForm
                :days="mode.days_of_week"
                :end_time="mode.end_time" 
                :start_time="mode.start_time" 
                :mode_id="mode.id" 
                :disabled="disabled"
            />
        </section>
</template>
<script>
    export default {
        props: {
            disabled: {
                type: Boolean,
                required: true
            },
            mode: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                repeat: {data:this.mode.frequency},
            }
        },
        watch:{
            'mode.frequency': function(){
                if(this.mode.frequency=='daily'){
                    this.repeat.data = 'daily'
                }
                else if(this.mode.frequency=='weekly'){
                    this.repeat.data = 'weekly'
                }
                else{
                    this.repeat.data = 'daily'
                }
            }
        }
    }
</script>
