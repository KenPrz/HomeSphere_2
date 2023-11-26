<script setup>
import AddAppliance from "./AddAppliance.vue";
import EditMode from "./EditMode.vue";
import Modal from "@/Components/Modal.vue";
import DeleteMode from "./DeleteMode.vue";
import { defineEmits } from "vue";
const emit = defineEmits(['getData']);
</script>
<template>
    <div class="flex ms-3 flex-col w-full min-h-[500px] overflow-y-auto">
        <section class="flex justify-between p-5 bg-white shadow-md rounded-md">
            <div class="text-md md:text-2xl font-semibold">
                {{ mode_name.value }}
            </div>
            <div class="flex">
                <button
                    @click="openAddApplianceModal"
                    class="group flex items-center justify-center transition-all duration-200 hover:bg-slate-500 hover:text-white border-gray-500 border rounded-xl md:rounded-full p-1 md:px-2 me-1"
                >
                    <svg
                        class="group-hover:stroke-white transition-all duration-200 stroke-gray-500 h-3 md:h-5 w-auto"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <g id="Edit / Add_Plus_Circle">
                            <path
                                id="Vector"
                                d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </g>
                    </svg>
                    <span class="text-xs md:text-sm">add</span>
                </button>
                <button
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
                <v-tab value="Activation"> Activation Type </v-tab>
            </v-tabs>
            <v-card-text>
                <v-window v-model="tab">
                    <v-window-item value="Appliances">
                        {{ selectedDevices }}
                    </v-window-item>
                    <v-window-item value="Activation">
                        {{}}
                    </v-window-item>
                </v-window>
            </v-card-text>
        </v-card>
    </div>
    <Modal
        :show="showAddApplianceModal"
        @close="closeAddApplianceModal"
        :maxWidth="'md'"
    >
        <AddAppliance @close="closeAddApplianceModal" />
    </Modal>
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
</template>
<script>
export default {
    props: {
        selectedMode: {
            type: Object,
            required: true,
        },
        selectedDevices: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            tab: null,
            showDeleteModeModal: false,
            showAddApplianceModal: false,
            showEditModeModal: false,
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
        // getNewData(){
        //     this.$emit('modeDeleted');
        // },
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
    },
    watch: {
        selectedMode: function (val) {
            this.mode_name.value = val.mode_name;
        },
    },
};
</script>
