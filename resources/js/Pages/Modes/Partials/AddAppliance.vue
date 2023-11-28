<script setup>
import { defineEmits } from "vue";
const emit = defineEmits(["close"]);

function cancel(data) {
    emit("close",data);
}
</script>
<template>
    <div class="container bg-white rounded-xl">
        <div class="flex flex-col m-5 ">
            <div class="text-2xl font-semibold mb-3">
                Add Appliance
            </div>
            <div class="mb-4">
                <label for="select1" class="block text-gray-700 font-medium mb-2">Room</label>
                <select required v-model="selectedRoom" @change="updateAppliances" id="select1" name="select1"
                    class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="" disabled>Select a room</option>
                    <option v-for="room in roomsData" :key="room.id" :value="room.id">{{ room.room_name }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="select2" class="block text-gray-700 font-medium mb-2">Appliance</label>
                <select required v-model="selectedAppliance" id="select2" name="select2"
                    class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="" disabled>Select an appliance</option>
                    <option v-for="device in selectedRoomDevices" :key="device.id" :value="device">{{ device.device_name
                    }}</option>
                </select>
            </div>
            <div class="flex flex-row justify-center mt-5">
                <button @click="submit"
                    class="flex-1 bg-gray-500 hover:bg-gray-400 transition-colors duration-200 text-white font-semibold py-2 px-4 rounded-full me-2">
                    Add
                </button>
                <button @click="close(null)"
                    class="flex-1 bg-white border-2 hover:bg-gray-200 transition-colors duration-200 text-slate-900 font-semibold py-2 px-4 rounded-full">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        mode_id: {
            type: Number,
            required: true,
        },
        roomsData: {
            type: Array,
            default: null,
        },
    },
    data() {
        return {
            selectedRoom: null,
            selectedAppliance: null,
        };
    },
    computed: {
        selectedRoomDevices() {
            const selectedRoom = this.roomsData.find(room => room.id === parseInt(this.selectedRoom));
            return selectedRoom ? selectedRoom.devices : [];
        },
    },
    methods: {
        submit(){
            const emitData = {
                    room: {
                        room_id: this.selectedRoom,
                        room_name: this.roomsData.find(room => room.id === parseInt(this.selectedRoom)).room_name,
                    },
                    device: {
                        device_id: this.selectedAppliance.id,
                        is_active: false,
                        custom_name: this.selectedAppliance.custom_name,
                        device_name: this.selectedAppliance.device_name,
                        device_type: this.selectedAppliance.device_type,
                },
            }
            this.close(emitData);
        },
        close(data) {
            this.$emit("close", data);
        },
    },
};
</script>
<!-- 
    { 
        "room": { "room_id": 1, "room_name": "sala" }, 
        "device": { "device_id": 3, "is_active": false, "custom_name": null, "device_name": "phone_charger", "device_type": "plug" } 
    }
 -->

<!-- 
    <script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { defineEmits } from "vue";
const emit = defineEmits(["close"]);

const form = useForm({
    room: "",
    device: "",
});

const submitForm = () => {
    form.post(route('modes.addDevice'), {
        onFinish: () => cancel(),
    });
};

function cancel() {
    emit("close");
}
</script>
<template>
    <div class="container bg-white rounded-xl">
        <form id="add_appliance" @submit.prevent="submitForm" class="flex flex-col my-10 mx-10">
            <div class="text-2xl font-semibold mb-3">
                Add Appliance {{ selectedRoom }}
            </div>
            <div class="mb-4">
                <label for="select1" class="block text-gray-700 font-medium mb-2">Room</label>
                <select v-model="form.room" @change="updateAppliances" id="select1" name="select1"
                    class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="" disabled>Select a room</option>
                    <option v-for="room in roomsData" :key="room.id" :value="room.id">{{ room.room_name }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="select2" class="block text-gray-700 font-medium mb-2">Appliance</label>
                <select v-model="form.device" id="select2" name="select2"
                    class="w-full px-4 py-2 border rounded-lg appearance-none">
                    <option value="" disabled>Select an appliance</option>
                    <option v-for="device in selectedRoomDevices" :key="device.id" :value="device.id">{{ device.device_name
                    }}</option>
                </select>
            </div>
            <div class="flex flex-row justify-center mt-5">
                <button type="submit"
                    class="flex-1 bg-gray-500 hover:bg-gray-400 transition-colors duration-200 text-white font-semibold py-2 px-4 rounded-full me-2">
                    Add
                </button>
                <button @click="cancel"
                    class="flex-1 bg-white border-2 hover:bg-gray-200 transition-colors duration-200 text-slate-900 font-semibold py-2 px-4 rounded-full">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props: {
        roomsData: {
            type: Array,
            default: null,
        },
    },
    data() {
    return {
        selectedRoom: '',
        selectedAppliance: '',
    };
},
    computed: {
        selectedRoomDevices() {
            const selectedRoom = this.roomsData.find(room => room.id === parseInt(this.selectedRoom));
            console.log(selectedRoom);
            return selectedRoom ? selectedRoom.devices : [];
        },
    },
};
</script>
 -->