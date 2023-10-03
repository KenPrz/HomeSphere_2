<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import SecondaryNavLink from "@/Components/SecondaryNavLink.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import Room from "./Partials/Room.vue";
import AddRoomForm from "./Partials/AddRoomForm.vue";
import AllRooms from "./Partials/AllRooms.vue";

// Add a state variable to track the active component
const activeComponent = ref("AllRooms");

const selectedRoom = ref(null);

const setActiveComponent = (componentName, room) => {
    activeComponent.value = componentName;
    selectedRoom.value = room;
};
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
                    <div class="flex p-2 bg-white flex-wrap rounded-md shadow-md h-16 min-h-full text-sm md:text-md mb-4">
                        <NavLink @click="setActiveComponent('AllRooms')" href="/rooms"
                            :active="activeComponent === 'AllRooms'">
                            All Rooms
                        </NavLink>
                        <button class="w-10 bg-red-200 m-2" v-for="room in rooms"
                            @click="setActiveComponent(room.room_name + ' ' + room.id, room)"
                            :active="activeComponent === room.room_name + ' ' + room.id">
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
                    {{ activeComponent }}
                    <div v-if="activeComponent === 'AllRooms'">
                        <AllRooms :rooms="rooms" />
                    </div>
                    <div v-else>
                        <Room :room="selectedRoom" />
                    </div>

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