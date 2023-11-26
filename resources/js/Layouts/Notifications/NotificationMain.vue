<script setup>
import NotificationCard from "./Partials/NotificationCard.vue";
</script>
<template>
    <div class="container flex-col">
        <div class="wrapper mx-5">
            <div class="text-xl font-semibold text-slate-600 my-2 pt-3">
                Notifications
            </div>
            <div class="flex mb-2">
                <button class="p-1 px-3 text-sm font-medium tracking-wide me-2 bg-slate-200 rounded-2xl text-slate-600 hover:text-slate-50 hover:bg-slate-500 transition-colors duration-200">
                    All
                </button>
                <button class="p-1 px-3 text-sm font-medium bg-slate-200 rounded-2xl text-slate-600 hover:text-slate-50 hover:bg-slate-500 transition-colors duration-200">
                    Unread
                </button>
            </div>
        </div>
        
        <div class="mx-1 max-h-72 overflow-y-scroll">
            <section class="py-1
            ">

            </section>
            <NotificationCard/>
            <NotificationCard/>
            <NotificationCard/>
            <NotificationCard/>
            <NotificationCard/>
            <NotificationCard/>
            <NotificationCard/>
        </div>

    </div>
</template>