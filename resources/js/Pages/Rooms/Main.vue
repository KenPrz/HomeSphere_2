<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>
        <main>
            <div class="container px-4">
                <div class="grid grid-cols-5 grid-rows-5 gap-4">
                    <div class="col-span-5 row-span-2">
                        <div class="w-full font-semibold text-2xl">
                            List of Rooms
                        </div>
                        <div class="flex p-2 bg-white rounded-md shadow-md h-16 text-sm md:text-md">
                            <button type="button" class="flex justify-center items-center rounded-2xl w-auto px-6 bg-zinc-600 text-white mx-1">
                                All Rooms
                            </button>
                            <button type="button" class="flex justify-center items-center rounded-2xl w-auto px-4 bg-white text-zinc-700 border-2 border-zinc-700 mx-1">
                                Living Room
                            </button>
                            <button type="button" class="flex justify-center items-center rounded-2xl w-auto px-4 bg-white text-zinc-700 border-2 border-zinc-700 mx-1">
                                Dining & Kitchen
                            </button>
                            <button type="button" class="flex justify-center items-center rounded-2xl w-auto px-4 bg-white text-zinc-700 border-2 border-zinc-700 mx-1">
                                Bedroom
                            </button>
                            <button type="button" class="flex justify-center items-center rounded-2xl w-auto px-4 bg-white text-zinc-700 border-2 border-zinc-700 mx-1">
                                Bathroom
                            </button>
                        </div>
                    </div>
                    <div class="col-span-5 row-span-3 row-start-3">
                        <div class="flex">
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
