<script setup>
import Modal from '@/Components/Modal.vue';
import AddAppliance from './AddAppliance.vue';
</script>
<template>
    <div class="w-full container flex flex-col">
        <section class="flex justify-end me-2">
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
    </div>
    <Modal :maxWidth="'md'" :show="showAddAppliance" @close="closeAddApplianceModal">
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
            showAddAppliance: false,
        }
    },
    methods: {
        openAddApplianceModal() {
            this.showAddAppliance = true;
        },
        closeAddApplianceModal() {
            this.showAddAppliance = false;
        },
    }
}
</script>