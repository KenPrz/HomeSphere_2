<script setup>
import RoomData from './RoomData.vue';
</script>
<template>
    <v-window>
        <v-carousel height="280" hideDelimiters>
            <template v-slot:prev="{ props }">
                <button class="hover:scale-105 transition duration-500 ease-in-out" @click="props.onClick">
                    <v-img width="40" src="img-assets\vectors\Prev-Button.svg" />
                </button>
            </template>
            <template v-slot:next="{ props }">
                <button class="hover:scale-105 transition duration-500 ease-in-out" @click="props.onClick">
                    <v-img width="40" src="img-assets\vectors\Next-Button.svg" />
                </button>
            </template>
            <v-carousel-item v-for="room in rooms" class="px-2">
                <RoomData
                    :room="room"
                />
            </v-carousel-item>
        </v-carousel>
    </v-window>
</template>
<script>
import { watch } from 'vue';
export default {
    props: {
        rooms: {
            type: Object,
            required: true,
        },
    },
};
</script>