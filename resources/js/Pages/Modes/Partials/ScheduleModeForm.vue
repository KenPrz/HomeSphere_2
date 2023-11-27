<script setup>
    import DailyForm from './DailyForm.vue';
    import WeeklyForm from './WeeklyForm.vue';
</script>
<template>
    <span class="text-lg font-medium">Schedule {{ repeat.value  }}</span>
        <label for="repeat" class="block">Repeat</label>
        <select v-model="repeat.value" id="repeat" name="repeat" :disabled="disabled" required class="w-full p-2 mb-2 border rounded-md">
            <option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
        </select>
        <section v-if="repeat.value=='Daily'">
            <DailyForm :mode_id="mode.id" :disabled="disabled"/>
        </section>
        <section v-if="repeat.value=='Weekly'">
            <WeeklyForm :mode_id="mode.id" :disabled="disabled"/>
        </section>
</template>
<script>
    export default {
        mounted() {
            this.repeat.value = 'Daily'
        },
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
                repeat: {data:''},
            }
        }
    }
</script>
