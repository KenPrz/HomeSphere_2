<template>
    <div class="flex items-center justify-center w-full mb-12">
        <label for="toggleB" class="flex items-center cursor-pointer">
            <div class="relative">
                <input
                    type="checkbox"
                    id="toggleB"
                    class="sr-only"
                    v-model="isChecked"
                />
                <div class="block bg-gray-300 w-14 h-8 rounded-full"></div>
                <div
                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"
                    :class="dotClasses"
                ></div>
            </div>
        </label>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isChecked: false,
        };
    },
    computed: {
        dotClasses() {
            return {
                'translate-x-full bg-green-500': this.isChecked,
            };
        },
    },
};
</script>
<style scoped>
/* Toggle B */
input:checked ~ .dot {
    transform: translateX(100%);
    background-color: #48bb78;
}
</style>
