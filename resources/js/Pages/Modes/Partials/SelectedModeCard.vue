<script setup>
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import ModeToggleModal from "./ModeToggleModal.vue";
import AppliancesInMode from "./AppliancesInMode.vue";
import ActivationTypeTab from "./ActivationTypeTab.vue";
import EditMode from "./EditMode.vue";
import Modal from "@/Components/Modal.vue";
import DeleteMode from "./DeleteMode.vue";
import { defineEmits } from "vue";
const emit = defineEmits(['getData','reloadData']);
</script>
<template>
    <div class="flex md:ms-3 flex-col w-full min-h-[500px] overflow-y-auto">
        <section class="flex justify-between p-5 bg-white shadow-md rounded-md">
            <div class="text-md md:text-2xl font-semibold">
                {{ mode_name.value }}
            </div>
            <div class="flex">
                <button
                    v-if="homeData.role == 'owner' || homeData.role == 'admin' || selectedMode.created_by == $page.props.auth.user.id"
                    @click="openEditRoomForm"
                    class="group flex items-center justify-center transition-all duration-200 hover:bg-slate-500 hover:text-white border-gray-500 border rounded-xl md:rounded-full p-1 md:px-2 me-1"
                >
                    <svg
                        class="group-hover:stroke-white transition-all duration-200 stroke-gray-500 h-3 md:h-5 w-auto"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="#000000"
                    >
                        <g id="SVGRepo_bgCarrier" stroke-width="0" />
                        <g
                            id="SVGRepo_tracerCarrier"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <g id="SVGRepo_iconCarrier">
                            <title />
                            <g id="Complete">
                                <g id="edit">
                                    <g>
                                        <path
                                            d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                        <polygon
                                            fill="none"
                                            points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        />
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                    <span class="text-sm">Edit</span>
                </button>
                <button
                    v-if="homeData.role == 'owner' || homeData.role == 'admin' || selectedMode.created_by == $page.props.auth.user.id"
                    @click="openDeleteModeModal"
                    class="group flex items-center justify-center transition-all duration-200 hover:bg-red-500 hover:text-white border-gray-500 border rounded-xl md:rounded-full p-1 md:px-2"
                >
                    <svg
                        class="group-hover:stroke-white transition-all duration-200 stroke-gray-500 h-3 md:h-5 w-auto"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <g id="SVGRepo_bgCarrier" stroke-width="0" />
                        <g
                            id="SVGRepo_tracerCarrier"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M4 7H20"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M6 7V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V7"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                            <path
                                d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </g>
                    </svg>
                    <span class="text-xs md:text-sm">Delete</span>
                </button>
            </div>
        </section>
        <v-card class="mt-3">
            <v-tabs bg-color="primary" color="secondary" v-model="tab">
                <v-tab value="Appliances"> Appliances </v-tab>
                <v-tab 
                    v-if="homeData.role == 'owner' || homeData.role == 'admin' || selectedMode.created_by == $page.props.auth.user.id" 
                    value="Activation"> 
                    Activation Type 
                </v-tab>
                <section v-if="selectedMode.activation_type != 'manual'" class="w-full flex justify-end items-center me-2 sm:me-6">
                    <div @click="openDisableModeModal" 
                        :class="selectedMode.is_enabled ? 'bg-slate-400 text-white' : 'bg-white text-black'"
                        class="text-xs md:text-sm rounded-xl border py-1 px-3 hover:bg-white hover:text-black transition-colors duration:200 cursor-pointer">
                        {{ selectedMode.is_enabled ? 'Disable' : 'Enable' }}
                    </div>
                </section>
            </v-tabs>
            <v-card-text>
                <v-window v-model="tab">
                    <v-window-item value="Appliances">
                        <AppliancesInMode :homeData="homeData" :mode="selectedMode" :roomsData="roomsData" :devices="selectedDevices" />
                    </v-window-item>
                    <v-window-item value="Activation">
                        <ActivationTypeTab v-if="homeData.role == 'owner' || homeData.role == 'admin' || selectedMode.created_by == $page.props.auth.user.id" 
                            :roomsData="roomsData" 
                            :mode="selectedMode"
                        />
                    </v-window-item>
                </v-window>
            </v-card-text>
        </v-card>
    </div>
    <Modal
        :maxWidth="'md'"
        :show="showEditModeModal"
        @close="closeEditModeModal"
    >
        <EditMode :mode_id="selectedMode.id" @close="closeEditModeModal" />
    </Modal>
    <Modal
        :hasClose="false"
        :maxWidth="'md'"
        :show="showDeleteModeModal"
        @close="closeDeleteModeModal"
    >
        <DeleteMode @close="closeDeleteModeModal" :mode="selectedMode"/>
    </Modal>
    <Modal
        :maxWidth="'sm'"
        :hasClose="false"
        :show="showToggleModeModal"
        @close="closeDisableModeModal"    
    >
        <ModeToggleModal
            :mode_id="selectedMode.id"
            :is_enabled="selectedMode.is_enabled"
            @toggle_enabled="reload"
            @close="closeDisableModeModal"/>
    </Modal>
</template>
<script>
export default {
    props: {
        homeData: {
            type: Object,
            required: true,
        },
        selectedMode: {
            type: Object,
            required: true,
        },
        selectedDevices: {
            type: Array,
            required: true,
        },
        roomsData: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            tab: null,
            showDeleteModeModal: false,
            showAddApplianceModal: false,
            showEditModeModal: false,
            showToggleModeModal: false,
            mode_name: { value: this.selectedMode.mode_name },
        };
    },
    methods: {
        openDeleteModeModal() {
            this.showDeleteModeModal = true;
        },
        closeDeleteModeModal(data) {
            if (data) {
                // this.getNewData();
                this.$emit("getData");
            }
            this.showDeleteModeModal = false;
        },
        openDisableModeModal() {
            this.showToggleModeModal = true;
        },
        closeDisableModeModal() {
            this.showToggleModeModal = false;
        },
        openAddApplianceModal() {
            this.showAddApplianceModal = true;
        },
        closeAddApplianceModal() {
            this.showAddApplianceModal = false;
        },
        openEditRoomForm() {
            this.showEditModeModal = true;
        },
        closeEditModeModal(data) {
            if (data) {
                this.mode_name.value = data;
            }
            this.showEditModeModal = false;
        },
        reload(){
            this.$emit('reloadData', this.selectedMode.id);
        }
    },
    watch: {
        selectedMode: function (val) {
            this.mode_name.value = val.mode_name;
        },
    },
};
</script>
