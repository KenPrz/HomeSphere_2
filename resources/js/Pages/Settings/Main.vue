<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
<template>
    <Head title="Settings" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 space-y-6 leading-tight">
                Settings
            </h2>
        </template>
        <main>
            <div class="container">
                <div class="flex-row w-full">
                    <div class="w-full font-semibold text-2xl">
                        Settings
                    </div>
                </div>
                <div class="flex flex-col text-md font-semibold">
                    <div class="flex">
                        <div class="text-md font-light">
                            
                            {{ 'Your Api Key: '+$page.props.api_key.api_key }}
                        </div>
                    </div>
                    <div class="flex">
                        <div class="text-md font-light">
                            {{ 'Your Invite Code: ' + $page.props.homeData.invite_code }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AuthenticatedLayout>
</template>