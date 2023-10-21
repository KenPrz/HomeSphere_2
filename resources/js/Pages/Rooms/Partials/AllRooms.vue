<script setup>
import { defineProps, defineEmits } from "vue";
import RoomCard from "./RoomCard.vue";

defineProps({
    rooms: {
        type: Object,
    },
});

const emits = defineEmits(["roomSelected"]);

const setActiveComponent = (componentName, room) => {
    emits("roomSelected", componentName, room);
};
</script>
<template>
    <div class="flex flex-col">
        <div class="container mx-auto">
            <div class="flex item-center">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 p-2 relative" v-for="room in rooms" :key="room.id">
                        <a @click="setActiveComponent(room.room_name + ' ' + room.id, room)">
                            <RoomCard
                                :room="room"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>