<template>
    <div>
        <div
            :class="[
                'm-3 p-3 flex flex-col h-[150px] w-[150px] bg-gray-600 shadow-lg rounded-lg hover:scale-105 cursor-pointer transition duration-500 ease-in-out',
                customClass,
                is_active.data ? 'bg-white text-black' : 'bg-gray-600 text-white',
            ]"
        >
            <div class="flex h-1/4">
                <div class="flex-1 items-center justify-center">
                    <div class="flex w-full" v-if="mode.activation_type == 'schedule'">
                        <div v-if="mode.frequency == 'daily'">
                            <svg :class="[is_active.data ? 'stroke-gray-600':'stroke-white']" class="h-12 w-auto duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div v-else-if="mode.frequency == 'weekly'">
                            <svg :class="[is_active.data ? 'stroke-gray-600':'stroke-white']" class="h-12 w-auto duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                        </div>
                        <!-- <svg :class="[is_active.data ? 'stroke-gray-600':'stroke-white']" class="h-12 w-auto duration-500 ease-in-out" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M36.66,54.45H8.84A2.5,2.5,0,0,1,6.35,52V12.12A2.49,2.49,0,0,1,8.84,9.63H48.68a2.49,2.49,0,0,1,2.49,2.49v22.4"></path><line x1="6.35" y1="20.63" x2="51.17" y2="20.63"></line><line x1="16.46" y1="9.63" x2="16.46" y2="4.63"></line><line x1="40.42" y1="9.63" x2="40.42" y2="4.63"></line><circle cx="45.22" cy="45.44" r="12.43"></circle><polyline points="45.22 36.7 45.22 45.82 49.57 49.16"></polyline></g></svg> -->
                    </div>
                    <div class="flex w-full" v-else-if="mode.activation_type == 'environment'">
                        <div v-if="mode.trigger_sensor == 'humidity'">
                            <svg :class="[is_active.data ? 'fill-gray-600':'fill-white']" class="h-12 w-auto duration-500 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M580-240q25 0 42.5-17.5T640-300q0-25-17.5-42.5T580-360q-25 0-42.5 17.5T520-300q0 25 17.5 42.5T580-240Zm-202-2 260-260-56-56-260 260 56 56Zm2-198q25 0 42.5-17.5T440-500q0-25-17.5-42.5T380-560q-25 0-42.5 17.5T320-500q0 25 17.5 42.5T380-440ZM480-80q-137 0-228.5-94T160-408q0-100 79.5-217.5T480-880q161 137 240.5 254.5T800-408q0 140-91.5 234T480-80Zm0-80q104 0 172-70.5T720-408q0-73-60.5-165T480-774Q361-665 300.5-573T240-408q0 107 68 177.5T480-160Zm0-320Z"/></svg>
                        </div>
                        <div v-else-if="mode.trigger_sensor == 'temperature'">
                            <svg :class="[is_active.data ? 'fill-gray-600':'fill-white']" class="h-12 w-auto duration-500 ease-in-out"  xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M520-520v-80h200v80H520Zm0-160v-80h320v80H520ZM320-120q-83 0-141.5-58.5T120-320q0-48 21-89.5t59-70.5v-240q0-50 35-85t85-35q50 0 85 35t35 85v240q38 29 59 70.5t21 89.5q0 83-58.5 141.5T320-120ZM200-320h240q0-29-12.5-54T392-416l-32-24v-280q0-17-11.5-28.5T320-760q-17 0-28.5 11.5T280-720v280l-32 24q-23 17-35.5 42T200-320Z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div v-if="homeData.role == 'owner' || mode.created_by == $page.props.auth.user.id" class="ms-1 mt-3">
                        <ToggleSwitch v-model="is_active.data" />
                    </div>
                    <div v-else class="mt-3">
                        <span :class="[is_active.data ? 'text-green-500 font-medium' : 'text-gray-300 font-medium']" class="text-xs">{{ is_active.data ? "• Active" : "• Inactive"  }}</span>
                    </div>
                </div>
            </div>
            <div @click="modeSelected(mode,devices)" class="flex flex-col h-3/4 pt-10">
                <h2 class="text-1xl">{{ mode.mode_name }}</h2>
                <h1 class="text-2xl font-ex">{{ is_active.data ? "ON" : "OFF" }}</h1>
            </div>
        </div>
    </div>
</template>

<script setup>
    import ToggleSwitch from "@/Components/ToggleSwitch.vue";
</script>
<script>
export default {
    props: {
        customClass: {
            type: String,
            required: false,
            default: "",
        },
        mode: {
            type: Object,
            required: true
        },
        devices: {
            type: Array,
            required: true
        },
        homeData: {
            type: Object,
            required: true
        },
    },
    data(){
        return{
            is_active: {data: this.mode.is_active},
            is_selected: false
        }
    },
    methods: {
        modeSelected(data,devices){
            this.$emit('mode-selected',data,devices);
        },
        submit() {
            axios.put(`/api/toggle-mode`, {
                mode_id: this.mode.id,
                home_id: this.homeData.id,
                is_active: this.is_active.data,
            })
                .then(response => {
                    // Handle the response as needed.
                    // console.log(response); //for debugging only remove at prod
                })
                .catch(error => {
                    // console.log(error); //for debugging only remove at prod
                });
        },
    },
    watch: {
        'is_active.data': function(){
            this.submit();
        }
    }
};
</script>
<style scoped>
    .overflow-ellipsis {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>