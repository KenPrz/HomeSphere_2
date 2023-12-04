<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import Room from "./Partials/Room.vue";
import AddRoomForm from "./Partials/AddRoomForm.vue";
import AllRooms from "./Partials/AllRooms.vue";
import NavButton from "./Partials/NavButton.vue";
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
    <AuthenticatedLayout
        :notifications="$page.props.notifications"
        :homeData="$page.props.homeData"
    >
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>
        <main>
            <div class="container">
                <div class="flex-row w-full">
                    <div class="w-full font-bold text-3xl">
                        List of Rooms
                    </div>
                    <div class="flex mx-2 p-2 bg-white flex-wrap overflow-ellipsis rounded-md shadow-md text-sm md:text-md mb-4">
                        <NavLink class="max-w-[120px] overflow-ellipsis mb-1" @click="setActiveComponent('AllRooms')" href="/rooms"
                            :active="activeComponent === 'AllRooms'">
                            All Rooms
                        </NavLink>
                        <NavButton v-for="room in rooms" class="max-w-[120px] overflow-ellipsis mb-1 text-[12px] sm:text-[16px] w-auto md:py-3 px-4 mx-2 border-black border-2 rounded-2xl hover:bg-zinc-500 hover:text-white transition duration-300"
                            @click="setActiveComponent(room.room_name + ' ' + room.id, room)"
                            :active="activeComponent === room.room_name + ' ' + room.id">
                            {{ room.room_name }}
                        </NavButton>
                        <button v-if="$page.props.homeData.role == 'owner' || $page.props.homeData.role == 'member'" @click="openAddRoomModal" type="button"
                            class="flex justify-center items-center rounded-2xl w-auto px-4 bg-zinc-600 text-white mx-1">
                            <img :src="'img-assets/vectors/plus-circle.svg'" alt="add" class="me-2 fill-white">
                            <span class="text-[12px] sm:text-[16px]">
                                add room
                            </span>
                        </button>
                    </div>
                    <div v-if="activeComponent === 'AllRooms'">
                        <AllRooms :rooms="rooms" @roomSelected="setActiveComponent" />
                    </div>
                    <div v-else>
                        <Room :room="selectedRoom" />
                    </div>
                </div>
            </div>
            <Modal :maxWidth="'lg'" :show="showAddRoomModal" @close="closeAddRoomModal">
                <div class="p-4 bg-white shadow sm:rounded-lg">
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
    }
};
</script>
<style scoped>
.overflow-ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>