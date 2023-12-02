<script setup>
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
</script>
<template>
    <div>
        <div :class="[
            'm-3 p-3 flex flex-col bg-gray-600 shadow-lg rounded-lg hover:scale-105 cursor-pointer transition duration-500 ease-in-out',
            customClass,
            is_active.data ? 'bg-white text-black' : 'bg-gray-600 text-white',
            'w-[115px] h-[115px] sm:h-[125px] sm:w-[125px] md:w-[140px] md:h-[140px] lg:w-[150px] lg:h-[150px]',
        ]">
            <div class="flex flex-1">
                <div v-if="device.device.device_type === 'light'" class="flex-1">
                    <svg class="h-10" :fill="is_active.data ? 'black' : '#A9A9A9'" viewBox="0 0 512 512"
                        xml:space="preserve">
                        <path
                            d="M428.2 172.2c0-47.5-19.3-90.6-50.4-121.8A171.7 171.7 0 0 0 256 0c-47.5 0-90.6 19.3-121.8 50.4a171.7 171.7 0 0 0-26.7 209h.1l.1.3c11 19.4 26.7 34.7 39 48.8 6.1 7 11.4 13.8 15 20a39 39 0 0 1 5.5 17.6v95.4a53.3 53.3 0 0 0 53.3 53.3h7.6a31.3 31.3 0 0 0 55.8 0h7.6a53.3 53.3 0 0 0 53.3-53.3V346c.2-5.7 2-11.3 5.5-17.6a194 194 0 0 1 24.8-30.9c10-11.2 21-23.3 29.2-38l.2-.2a171 171 0 0 0 23.7-87.2zM311.8 461.8a28.5 28.5 0 0 1-20.3 8.4h-71a28.5 28.5 0 0 1-28.7-28.7v-5.3l120 25.5zm8.4-20.3c0 1.7-.2 3.4-.5 5l-128-27.1v-33.5l128.5 27.3v28.3zm0-45.1-128.4-27.3v-11h128.4v38.3zm63-149.3-.2.2v.1c-8.5 15.4-23 29.9-36.2 45a151 151 0 0 0-17.9 24c-3 5.2-5.3 11-6.9 17H190c-1.6-6-4-11.8-7-17-7.4-13-17.8-24.1-27.9-35.3a191.9 191.9 0 0 1-26-33.7l-.2-.1v-.2a147 147 0 0 1 22.8-179.3A147 147 0 0 1 256 24.6a147 147 0 0 1 104.4 43.2A147 147 0 0 1 383 247.1z" />
                    </svg>
                </div>
                <div v-else class="flex-1">
                    <svg class="h-10" :fill="is_active.data ? 'black' : 'white'" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 9v3a5 5 0 0 1-5 5M7 9v3a5 5 0 0 0 5 5m0 0v4M8 3v3m8-3v3M5 9h14" stroke="#000"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div v-if="homeData.role == 'owner' || created_by == $page.props.auth.user.id" class="ms-1 mt-3">
                        <ToggleSwitch v-model="is_active.data" />
                    </div>
                    <div v-else class="mt-3">
                        <span :class="[is_active.data ? 'text-green-500 font-medium' : 'text-gray-300 font-medium']" class="text-xs">{{ is_active.data ? "• Active" : "• Inactive"  }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col flex-1">
                <!-- Adjust text size based on screen size -->
                <h2 class="text-sm sm:text-md lg:text-lg overflow-ellipsis">
                    <span v-if="device.device.custom_name!=null">
                        {{ device.device.custom_name }}
                    </span>
                    <span v-else>
                        {{ device.device.device_name }}
                    </span>
                </h2>
                <p class="tex-xs font-light">{{ device.room.room_name }}</p>
                <div class="flex">
                    <h1 class="w-1/2 text-lg sm:text-xl lg:text-2xl font-ex">
                        {{ is_active.data ? 'ON' : 'OFF' }}
                    </h1>
                    <button v-if="homeData.role == 'owner' || created_by == $page.props.auth.user.id" @click="deleteDevice" class="w-1/2 text-xs font-medium p-2" :class="[is_active.data ? 'hover:text-red-500': 'hover:text-red-400']">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            device: {
                type: Object,
                required: true
            },
            homeData: {
                type: Object,
                required: true
            },
            created_by: {
                type: Number,
                required: true
            },
            customClass:{
                type: String,
                required: false,
                default: ""
            }
        },
        data() {
            return {
                is_active: {data: this.device.device.is_active}
            }
        },
        watch: {
            device: {
                handler: function (val, oldVal) {
                    this.is_active.data = val.device.is_active;
                },
                deep: true
            },
            is_active: {
                handler: function (val, oldVal) {
                    this.$emit('update:device_state', this.device.device.device_id, val.data);
                },
                deep: true
            }
        },
        methods: {
            deleteDevice() {
                this.$emit('delete:device', this.device.device.device_id);
            }
        }
    }
</script>
<style scoped>
.overflow-ellipsis {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>