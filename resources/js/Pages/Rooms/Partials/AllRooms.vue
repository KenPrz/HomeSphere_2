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
    <div class="flex flex-row">
        <div class="container">
            <div class="flex flex-wrap">
                <div class="w-1/2 p-2 relative" v-for="room in rooms" :key="room.id">
                        <RoomCard :roomId="room.id" :temperature="room.temperature" :humidity="room.humidity" :roomName="room.room_name"
                            :deviceCount="room.device_count" />
                </div>
            </div>
        </div>
    </div>
</template>