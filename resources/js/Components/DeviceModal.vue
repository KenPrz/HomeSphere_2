<script setup>
import ToggleSwitch from './ToggleSwitch.vue';
import { defineEmits } from "vue";
import TextInput from './TextInput.vue';
import InputError from './InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Modal from './Modal.vue';
const { device,room_id } = defineProps({
    device: Object
});

const emit = defineEmits(["close"]);
const form1 = useForm({
    device_id: device.id,
    device_name: '',
});
const submitForm1 = () => {
    form1.post(route('device.new-name'), {
        onSuccess: () => cancel(),
    });
};
const form2 = useForm({
    device_id: device.id,
});
const submitForm2 = () => {
    form2.delete(route('device.delete'), {
        onFinish: () => cancel(),
    });
};
function cancel() {
    emit("close");
}
</script>
<template>
    <div class="container flex flex-col">
        <div class="flex border-b-2 py-2 ps-2 text-lg font-semibold">
            <section v-if="showEdit==false" class="w-3/4 flex flex-col">
                <span>{{ device.custom_name ?? device.device_name }}</span>
                <span v-if="device.custom_name !== null" class="font-light text-xs">{{ 'System Name: '+device.device_name }}</span>
            </section>
            <section v-else class="w-3/4">
                <form id="new_device_name" @submit.prevent="submitForm1">
                    <label for="device_name" class="text-sm font-light">New device name</label>
                    <TextInput
                        id="device_name"
                        class="h-8 font-normal"
                        v-model="form1.device_name"
                        required
                        autocomplete="new device name"
                        autofocus
                        :placeHolder="device.device_name"
                    />
                    <InputError class="mt-2 text-xs font-light" :message="form1.errors.device_name" />
                </form>
            </section>
            <section v-if="device.room_owner_id==$page.props.auth.user.id || $page.props.homeData.role == 'owner' || $page.props.homeData.role == 'admin'" class="w-1/4 flex justify-end items-center">
                <button @click="showEdit=!showEdit">
                    <img class="w-5 me-2" :src="'img-assets/vectors/Edit.svg'" alt="">
                </button>
                <button v-if="showEdit==false" @click="showModal=true">
                    <img class="w-5 me-2" :src="'img-assets/vectors/Delete.svg'" alt="">
                </button>
            </section>
        </div>
        <div class="flex flex-col ms-2">
            <div class="flex flex-col">
                <section class="pt-2">
                    Type: <span class="fond-semibold">{{ device.device_type }}</span>
                </section>
                <section>
                    Room: <span class="fond-semibold">{{ device.room_name }}</span>
                </section>
            </div>
            <div class="flex">
                <section class="flex flex-col py-1 w-3/4">
                    <span class="text-md font-medium">Device State</span>
                    <span class="text-xs font-light text-gray-500">toggle the device state</span>
                </section>
                <section class="flex items-center justify-center w-1/4">
                    <ToggleSwitch v-model:modelValue="device.is_active" />
                </section>
            </div>
        </div>
        <div class="flex mx-3 mt-3">
            <button @click="cancel()" class="bg-zinc-500 hover:bg-zinc-600 transition-colors duration-200 w-full p-2 rounded-full">
                <span class="text-sm font-semibold text-white">Close</span>
            </button>
            <button form="new_device_name" v-if="showEdit==true" type="submit" class="ms-2 bg-blue-500 hover:bg-blue-600 transition-colors duration-200 w-full p-2 rounded-full">
                <span class="text-sm font-semibold text-white">Update</span>
            </button>
        </div>
    </div>
    <Modal :hasClose="false" :maxWidth="'sm'" :show="showModal" @close="showModal=false">
        <div class="bg-white p-6 rounded-lg shadow-md w-auto">
        <h2 class="text-xl font-semibold mb-4">Delete?</h2>
        <p class="mb-4">Are you sure you want to delete this device?</p>
        <div class="flex">
            <form id="delete_device_form" @submit.prevent="submitForm2">
                <button
                    type="submit"
                    class="flex-1 text-sm bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
                >
                    Yes, Delete it
                </button>
            </form>
            <button
                @click="showModal=false"
                class="flex-1 text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-4 hover:bg-gray-400 transition duration-300"
            >
                No, cancel
            </button>
        </div>
    </div>
    </Modal>
</template>
<script>
    import axios from 'axios';
    export default {
    props: {
        device: Object,
    },
    data() {
        return {
            showEdit: false,
            showModal: false,
        }
    },
    methods: {
        toggle() {
            axios.post(`/api/device-toggle`, {
                device_id: this.device.id,
                room_id: this.device.room_id,
                is_active: this.device.is_active,
            })
                .then(response => {
                    // Handle the response as needed.

                    console.log(response);
                })
                .catch(error => {
                    // Handle the error as needed.

                    console.log(error);
                });
        },
    },
    watch: {
        'device.is_active': function () {
            this.toggle();
        },
    }
}
</script>
<style scoped>
    .styled-input {
        width: 100%;
        padding: 4px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .styled-input::placeholder {
            color: #999;
            font-weight: 400;
        }
</style>