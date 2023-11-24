<script setup>
</script>
<template>
    <div class="flex ms-3 flex-col bg-white shadow-md rounded-md w-full">
        <section class="flex justify-between">
            <div class="text-lg font-semibold">
                {{ selectedMode.mode_name }}
            </div>
            <div class="flex">
                <button class="flex border px-2 mx-1 rounded-xl bg-white hover:text-white hover:bg-slate-500 transition-colors duration-200">
                    edit
                </button>
                <button class="flex border px-2 mx-1 rounded-xl bg-white hover:text-white hover:bg-slate-500 transition-colors duration-200">
                    delete
                </button>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    props: {
        selectedMode: {
            type: Object,
            required: true
        }
    }
}
</script>