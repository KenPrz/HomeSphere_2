<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>
        <main>
            <div class="w-full text-xl">
                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat ut quos quod eveniet tenetur omnis illo, facilis assumenda. Eligendi dolorum sint rerum tenetur autem deleniti ducimus sapiente? Error, modi incidunt?</h1>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
