<script setup>
import Modal from '@/Components/Modal.vue';
import AddMode from './AddMode.vue';
import ClickableModeCard from './ClickableModeCard.vue';
import SelectedModeCard from './SelectedModeCard.vue';
</script>
<template>
        <div class="container flex p-4">
            <div class="flex flex-col bg-white shadow-md rounded-md pt-2">
                <section class="flex flex-col max-h-[500px] overflow-y-auto">
                    <div v-for="mode in modes" :key="mode.id">
                        <ClickableModeCard
                            :mode="mode"
                            :devices="devices"
                            @mode-selected="selectedMode"
                        />
                    </div>
                </section>
                <section class="flex items-center justify-center mt-auto">
                    <button @click="showAddModeModal()" class="flex items-center justify-center bg-slate-500 hover:bg-slate-600 transition-colors duration-300 text-white w-full m-2 rounded-md h-10">
                        <img class="h-[25px] me-1" :src="'img-assets/vectors/add_white.svg'" alt="">
                        <span>add mode</span>
                    </button>
                </section>
            </div>
            <SelectedModeCard @getData="getNewData" :roomsData="roomsData"  :selectedMode="modeData.data" :selectedDevices="devicesData.data"/>
        </div>
        <Modal :maxWidth="'md'" :show="showAddMode" @close="closeAddModeModal">
            <div class="p-4">
                <AddMode :title="'Add a Mode'"  @close="closeAddModeModal"/>
            </div>
        </Modal>
</template>
<script>
export default {
    props: {
            homeData: {
                type: Object,
                required: true
            },
            modes: {
                type: Array,
                default: null
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
                showAddMode: false,
                modeData: {data: this.modes[0]},
                devicesData: {data: this.devices}
            }
        },
        methods: {
            showAddModeModal(){
                this.showAddMode=true;
            },
            closeAddModeModal(){
                this.showAddMode=false;
            },
            selectedMode(data,devices){
                this.modeData.data=data;
                this.devicesData.data=devices;
            },
            getNewData(){
                this.modeData.data=this.modes[0];
            }
        }
}
</script>