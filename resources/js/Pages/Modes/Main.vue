<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 space-y-6 leading-tight">
                Modes
            </h2>
        </template>
        <main>
            <div class="container">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit dolorem quasi possimus veritatis pariatur accusantium ipsam recusandae nihil enim delectus!
            </div>
        </main>
    </AuthenticatedLayout>
    
</template>