<script setup>
import { defineProps, defineEmits } from "vue";
import RoomCard from "./RoomCard.vue";
defineProps({
    rooms: {
        type: Object,
    },
});
const emits = defineEmits(["roomSelected"]);

const setActiveComponent = (room) => {
    emits("roomSelected", room);
};
</script>
<template>
    <div class="flex flex-col"> <!-- Use a column layout for mobile -->
        <div class="container mx-auto">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/2 p-2 relative" v-for="room in rooms" :key="room.id">
                    <a @click="setActiveComponent(room.room_name + ' ' + room.id, room)"
                        :active="activeComponent === room.room_name + ' ' + room.id">
                        <RoomCard :room="room" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>