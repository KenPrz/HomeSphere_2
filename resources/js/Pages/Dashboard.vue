<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Main from '@/Pages/Home/Main.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head title="Dashboard" />
        <Main />
</template>
<script>
export default {
    props: {
        homeData: Object,
        userList:Object,
    }
};
</script>