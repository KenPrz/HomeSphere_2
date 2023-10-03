<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import RoomCard from "./RoomCard.vue";
import Link from "@/Components/SideNavLink.vue";
defineProps({
    rooms: {
        type: Object,
    },
});
</script>
<template>
    <div class="flex flex-col"> <!-- Use a column layout for mobile -->
        <div class="container mx-auto">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/2 p-2 relative" v-for="room in rooms" :key="room.id">
                    <!-- Use full width on small screens and half width on larger screens -->
                    <RoomCard :room="room"/>
                </div>
            </div>
        </div>
    </div>
</template>