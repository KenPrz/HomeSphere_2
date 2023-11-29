<script setup>
import Modal from '@/Components/Modal.vue';
import AddAppliance from './AddAppliance.vue';
import ModeDeviceCard from './ModeDeviceCard.vue';
</script>
<template>
    <div class="w-full container flex flex-col">
        <section class="flex justify-between me-2">
            <span class="text-gray-500 text-xs md:text-sm ml-2">Hint: Toggle device state to set the state upon mode activation.</span>
            <button @click="openAddApplianceModal"
                class="group flex items-center justify-center transition-all duration-200 hover:bg-slate-500 hover:text-white border-gray-500 border rounded-xl md:rounded-full p-1 md:px-2 me-1">
                <svg class="group-hover:stroke-white transition-all duration-200 stroke-gray-500 h-3 md:h-5 w-auto"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="Edit / Add_Plus_Circle">
                        <path id="Vector"
                            d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <span class="text-xs md:text-sm">Add Appliance</span>
            </button>
        </section>
        <section  class="mt-3 flex flex-wrap max-h-[400px] md:max-h-[500px] overflow-y-scroll">
                <ModeDeviceCard
                    @update:device_state="updateDeviceState"
                    @delete:device="deleteDevice"
                    v-for="device in modeDevices.data" 
                    :key="device.id" 
                    :device="device" 
                />
        </section>
        <section class="flex justify-end me-2">
            <button @click="updateModeDevices" v-if="hasChanges==true" class="bg-blue-500 h-8 text-white hover:bg-blue-600 transition-colors duration-200 w-32 rounded-full me-2 ">Save changes</button>
        </section>
    </div>
    <Modal :maxWidth="'md'" :show="showAddAppliance" @close="justCloseMe">
        <div class="p-4">
            <AddAppliance :mode_id="mode.id"  :roomsData="roomsData" :title="'Add an Appliance'" @close="closeAddApplianceModal" />
        </div>
    </Modal>
</template>
<script>
export default {
    props: {
        mode: {
            type: Object,
            required: true
        },
        devices: {
            type: Array,
            default: null
        },
        roomsData: {
            type: Array,
            default: null
        },
    },
    data() {
        return {
            oldDeviceArrayLength: 0,
            hasChanges: false,
            showAddAppliance: false,
            modeDevices: {data: this.mode.device_list},
        }
    },
    mounted() {
        if(this.modeDevices.data !== null){
            this.oldDeviceArrayLength = this.modeDevices.data.length;
        }
    },
    watch: {
            'mode.id': function(newVal, oldVal) {
                this.modeDevices.data = this.mode.device_list;
            }
        },
    methods: {
        openAddApplianceModal() {
            this.showAddAppliance = true;
        },
        closeAddApplianceModal(data) {
            if (data !== null) {
                if(this.modeDevices.data === null){
                    this.modeDevices.data = [data];
                    this.showAddAppliance = false;
                    this.hasChanges = true;
                }else{
                    const isDuplicate = this.modeDevices.data.some(item =>
                    item.room.room_id === data.room.room_id &&
                    item.device.device_id === data.device.device_id
                    );
                    if (isDuplicate) {
                        alert('This appliance is already in the mode!');
                    } else {
                        this.modeDevices.data.push(data);
                        this.hasChanges = true;
                        this.showAddAppliance = false;
                    }
                }
            } else {
                this.showAddAppliance = false;
            }
        },
        justCloseMe(){
            this.showAddAppliance = false;
        },
        updateModeDevices(){
            this.$inertia.put(route('mode.updateDeviceList'), {
                mode_id: this.mode.id,
                device_list: this.modeDevices.data,
            }, {
                onSuccess: () => {
                    this.hasChanges = false;
                    this.oldDeviceArrayLength = this.modeDevices.data.length;
                },
            });
        },
        updateDeviceState(device_id, state){
            const deviceIndex = this.modeDevices.data.findIndex(device => device.device.device_id === device_id);
            this.modeDevices.data[deviceIndex].device.is_active = state;
            this.hasChanges = true;
        },
        deleteDevice(device_id){
            const deviceIndex = this.modeDevices.data.findIndex(device => device.device.device_id === device_id);
            this.modeDevices.data.splice(deviceIndex, 1);
            this.hasChanges = true;
        }
    }
}
</script>