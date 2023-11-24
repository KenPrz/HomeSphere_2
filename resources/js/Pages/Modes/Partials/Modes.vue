<script setup>
import Modal from '@/Components/Modal.vue';
import AddMode from './AddMode.vue';
import ClickableModeCard from './ClickableModeCard.vue';
import SelectedModeCard from './SelectedModeCard.vue';
</script>
<template>
        <div class="container flex p-4">
            <div class="flex flex-col bg-white shadow-md rounded-md">
                <section class="flex flex-col max-h-[500px] overflow-y-auto">
                    <div v-for="mode in modes" :key="mode.id">
                        <ClickableModeCard
                            :mode="mode"
                            @mode-selected="selectedMode"
                        />
                    </div>
                </section>
                <section class="flex items-center justify-center">
                    <button @click="showAddModeModal()" class="flex items-center justify-center bg-slate-500 hover:bg-slate-600 transition-colors duration-300 text-white w-full m-2 rounded-md h-10">
                        <img class="h-[25px] me-1" :src="'img-assets/vectors/add_white.svg'" alt="">
                        <span>add mode</span>
                    </button>
                </section>
            </div>
            <SelectedModeCard :selectedMode="modeData.data"/>
        </div>
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
            }
        },
        data() {
            return {
                showAddMode: false,
                modeData: {data: this.modes[0]},
            }
        },
        methods: {
            showAddModeModal(){
                this.showAddMode=true;
            },
            closeAddModeModal(){
                this.showAddMode=false;
            },
            selectedMode(data){
                this.modeData.data=data;
            }
        }
}
</script>