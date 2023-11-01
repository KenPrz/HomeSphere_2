<script setup>
import DeviceModal from './DeviceModal.vue';
import Modal from './Modal.vue';
</script>
<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block w-full sm:px-6 lg:px-8">
                <div
                    class="min-w-full justify-between flex mx-0 mb-2 text-base text-left text-white rounded-tl-lg rounded-tr-lg bg-zinc-600">
                    <div v-for="(header, index) in tableHeaders" :key="index"
                        class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">
                        {{ header.text }}
                    </div>
                </div>
                <div class="overflow-y-auto" :class="maxHeight">
                    <div class="mx-0">
                        <!-- {{ paginatedData }} -->
                        <div @click="showDeviceModal(item)" v-for="item in paginatedData" :key="item.id"
                            class="min-w-full flex justify-between mb-2 rounded-md text-sm text-left text-black bg-white hover:bg-gray-300 cursor-pointer">
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">
                                {{ item.room_name }}
                            </div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">
                                {{ item.device_type }}
                            </div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">
                                {{ item.device_name }}
                            </div>
                            <div class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5">
                                {{ item.is_active ? "Active" : "Inactive" }}
                            </div>
                        </div>
                    </div>
                    <slot />
                    <div v-if="Pagenated" class="flex justify-between items-center">
                        <span class="text-gray-800 text-xs"> showing <b class="text-black">{{ currentPage }}</b> of <b
                                class="text-black"> {{ totalPages }}</b> entries</span>
                        <!-- Previous Page Button -->
                        <div class="flex items-center bg-white rounded-md border-2">
                            <button @click="currentPage -= 1" :disabled="currentPage === 1"
                                class="px-2 py-1 border-slate hover:bg-slate-200 duration-200 cursor-pointer transition-colors">
                                Previous
                            </button>
                            <!-- Page Numbers -->
                            <div>
                                <button v-for="pageNumber in totalPages" :key="pageNumber" @click="goToPage(pageNumber)"
                                    class="px-3 py-1 border-slate "
                                    :class="{ 'bg-gray-500 text-white': pageNumber === currentPage, 'bg-gray-100 text-gray-700': pageNumber !== currentPage }">
                                    {{ pageNumber }}
                                </button>
                            </div>
                            <!-- Next Page Button -->
                            <button @click="currentPage += 1" :disabled="currentPage === totalPages"
                                class="px-2  py-1 border-slate rounded-r-md bg-zinc-600 text-white">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal :maxWidth="'sm'" :show="isDeviceModalVisible" @close="closeDeviceModal">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <DeviceModal @close="closeDeviceModal" :device="selectedRow" />
        </div>
    </Modal>
</template>
<script>

export default {
    props: {
        tableHeaders: Array,
        tableData: Array,
        maxHeight: String,
        itemsPerPage: {
            type: Number,
            default: 5,
        },
        Pagenated: {
            type: Boolean,
            default: true,
        }
    },
    data() {
        return {
            currentPage: 1,
            isDeviceModalVisible: false,
            selectedRow: null,
        };
    },
    computed: {
        startIndex() {
            return (this.currentPage - 1) * this.itemsPerPage;
        },
        endIndex() {
            return this.currentPage * this.itemsPerPage;
        },
        paginatedData() {
            return this.tableData.slice(this.startIndex, this.endIndex);
        },
        totalPages() {
            return Math.ceil(this.tableData.length / this.itemsPerPage);
        },
    },
    methods: {
        goToPage(pageNumber) {
            if (pageNumber >= 1 && pageNumber <= this.totalPages) {
                this.currentPage = pageNumber;
            }
        },
        showDeviceModal(row) {
            this.selectedRow = row;
            this.isDeviceModalVisible = true;
        },
        closeDeviceModal() {
            this.isDeviceModalVisible = false;
        },
    },
};
</script>