<script setup>
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const emit = defineEmits(["close"]);

const form = useForm({
    room_name: '',
    room_icon: '',
});

const selectedPictureName = ref('');

const submit = () => {
    form.post(route('rooms.addRoom'), {
        onSuccess: () => {
            form.reset('room_name');
            close();
        },
    });
};
const selectPicture = (pictureType) => {
    if (pictureType === 'bedroom') {
        form.room_icon = 'img-assets/vectors/Room Vectors/bedroom.svg';
        selectedPictureName.value = 'Bedroom icon';
    } else if (pictureType === 'living_room') {
        form.room_icon = 'img-assets/vectors/Room Vectors/living_room.svg';
        selectedPictureName.value = 'Living Room icon';
    } else if (pictureType === 'dining_kitchen') {
        form.room_icon = 'img-assets/vectors/Room Vectors/dining_kitchen.svg';
        selectedPictureName.value = 'Dining Kitchen icon';
    } else if (pictureType === 'bathroom') {
        form.room_icon = 'img-assets/vectors/Room Vectors/bathroom.svg';
        selectedPictureName.value = 'Bathroom icon';
    }else if (pictureType=='default'){
        form.room_icon = 'img-assets/nav-vectors/rooms.svg';
        selectedPictureName.value = 'Default';
    }
};
function close() {
    emit('close');
}
</script>

<template>
    <div>
        <h2 class="text-2xl mt-5 mx-5 py-4 font-semibold">Select a room icon</h2>
        
        <div class="room-container mx-5 flex justify-between">
            <div class="hover:bg-gray-400 p-3 rounded-xl transition-colors duration-300" id="default" @click="selectPicture('default')" style="cursor: pointer;">
                <img class="h-14" :src="'img-assets/nav-vectors/rooms.svg'" alt="default">
            </div>
            <div class="hover:bg-gray-400 p-3 rounded-xl transition-colors duration-300" id="bedroom" @click="selectPicture('bedroom')" style="cursor: pointer;">
                <img class="h-16" :src="'img-assets/vectors/Room Vectors/bedroom.svg'" alt="Bedroom">
            </div>
            <div class="hover:bg-gray-400 p-3 rounded-xl transition-colors duration-300" id="livingRoom" @click="selectPicture('living_room')" style="cursor: pointer;">
                <img class="h-16" :src="'img-assets/vectors/Room Vectors/living_room.svg'" alt="Living Room">
            </div>
            <div class="hover:bg-gray-400 p-3 rounded-xl transition-colors duration-300" id="kitchen" @click="selectPicture('dining_kitchen')" style="cursor: pointer;">
                <img class="h-16" :src="'img-assets/vectors/Room Vectors/dining_kitchen.svg'" alt="Dining Kitchen">
            </div>
            <div class="hover:bg-gray-400 p-3 rounded-xl transition-colors duration-300" id="bathroom" @click="selectPicture('bathroom')" style="cursor: pointer;">
                <img class="h-16" :src="'img-assets/vectors/Room Vectors/bathroom.svg'" alt="Bathroom">
            </div>
        </div>

        <Head title="Create Room" />

        <div class="flex flex-col justify-center items-start p-5">
            <h2 class="text-2xl py-4 font-semibold">Add a Room</h2>

            <form class="w-full" @submit.prevent="submit">
                <div class="flex flex-col w-full h-full">
                    <div class="w-full flex-1 mb-1">
                        <label for="selected_picture" class="text-sm font-medium">Room name:</label>
                        <TextInput placeholder="Room Name" id="room_name" type="text" class="mt-1 block w-full"
                            v-model="form.room_name" required autofocus autocomplete="room_name" />
                        <InputError class="mt-2" :message="form.errors.room_name" />
                    </div>

                    <div class="w-full flex-1 mb-1">
                        <label for="selected_picture" class="text-sm font-medium">Selected Picture:</label>
                        <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" type="text" id="selected_picture" v-model="selectedPictureName"
                            readonly />
                        <InputError class="mt-2" :message="form.errors.room_icon" readonly />
                    </div>
                </div>

                <div class="flex flex-col items-center mt-5">
                    <SecondaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Add Room
                    </SecondaryButton>
                </div>
            </form>
        </div>
    </div>
</template>