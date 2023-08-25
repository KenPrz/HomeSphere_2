<template>
    <div class="w-full max-w-screen-lg mx-auto p-6 md:p-8 lg:p-10">
        <div class="flex flex-col md:flex-row justify-between items-start">
            <LeftSection />
            <LoginSection/>
        </div>
    </div>
</template>
<script setup>
    import LeftSection from "./LeftSection.vue";
    import LoginSection from "@/Pages/Auth/LoginSection.vue";
</script>
