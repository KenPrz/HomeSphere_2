<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import Room from "./Partials/Room.vue";
import AddRoomForm from "./Partials/AddRoomForm.vue";
import AllRooms from "./Partials/AllRooms.vue";
</script>
<template>
    <Head title="Rooms" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>
        <main>
            <div class="container">
                <div class="flex-row w-full">
                    <div class="w-full font-semibold text-2xl">
                        List of Rooms
                    </div>
                    <div class="flex p-2 bg-white flex-wrap rounded-md shadow-md h-16 text-sm md:text-md mb-4">
                        <button type="button"
                            class="flex justify-center items-center rounded-2xl w-auto px-6 bg-zinc-600 text-white mx-1">
                            All Rooms
                        </button>
                        <button v-for="room in rooms" :key="room.id" type="button"
                            class="flex justify-center items-center rounded-2xl w-auto px-4 bg-white text-zinc-700 border-2 border-zinc-700 mx-1">
                            {{ room.room_name }}
                        </button>
                        <button @click="openAddRoomModal" type="button"
                            class="flex justify-center items-center rounded-2xl w-auto px-4 bg-zinc-600 text-white mx-1">
                            <img :src="'img-assets/vectors/plus-circle.svg'" alt="add" class="me-2 fill-white">
                                <span>
                                    add room
                                </span>
                        </button>
                    </div>
                    <!-- <AllRooms 
                        :rooms="rooms"
                    /> -->
                    <Room
                        :roomName="'Living Room'" 
                        :deviceCount="5" 
                        :initialChecked="false" 
                        :temperature="36.2" 
                        :humidity="70" 
                    />
                </div>
            </div>
            <Modal :show="showAddRoomModal" @close="closeAddRoomModal">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <AddRoomForm @close="closeAddRoomModal" />
                </div>
            </Modal>
        </main>
    </AuthenticatedLayout>
</template>

<script>
const showAddRoomModal = ref(false);
const openAddRoomModal = () => {
    showAddRoomModal.value = true;
}
const closeAddRoomModal = () => {
    showAddRoomModal.value = false;
}

export default {
    props: {
        rooms: Object,
    },
};
</script>