<script setup>
import { ref } from "vue";
import { defineEmits } from "vue";
const emit = defineEmits(["close"]);
function cancel() {
    emit("close");
}
</script>

<template>
    <div class="container bg-white rounded-xl">
        <form action="#" class="flex flex-col my-10 mx-10">
            <div class="text-2xl font-semibold mb-3">
                Add Appliance
            </div>
            <div class="mb-4">
                <label for="select1" class="block text-gray-700 font-medium mb-2">Room</label>
                <select id="select1" name="select1" class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option class="bg-white" value="option1">Option 1</option>
                    <option class="bg-white" value="option2">Option 2</option>
                    <option class="bg-white" value="option3">Option 3</option>
                    <option class="bg-white" value="option4">Option 4</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="select2" class="block text-gray-700 font-medium mb-2">Appliance</label>
                <select id="select2" name="select2" class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                    <option value="option4">Option 4</option>
                </select>
            </div>
            <div class="flex flex-row justify-center mt-5">
                <button
                    class="flex-1 bg-gray-500 hover:bg-gray-400 transition-colors duration-200 text-white font-semibold py-2 px-4 rounded-full me-2">
                    Add
                </button>
                <button
                    class="flex-1 bg-white border-2 hover:bg-gray-200 transition-colors duration-200 text-slate-900 font-semibold py-2 px-4 rounded-full"
                    @click="cancel">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>
<script>

</script>