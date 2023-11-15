<script setup>
import { ref } from "vue";
import TopNav from "@/Layouts/TopNav.vue";
import SideNav from "@/Layouts/SideNav.vue";
</script>
<template>
    <div class="grid grid-cols-1 min-h-screen">
        <!-- Navbar -->
            <TopNav
                :homeData="homeData"
            />
        <!-- End Navbar -->
        <div class="md:flex">
            <!-- Sidebar -->
            <SideNav/>
            <!-- End Sidebar -->
            <!-- Main Content -->
            <div id="mainDiv" class="flex-1 min-h-screen bg-gray-100">
                <!-- Page Content -->
                <main class="py-4 px-4">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            homeData: {
                type: Object,
                required: true
            }
        }
    }
</script>
<style scoped>
#mainDiv {
    margin-left: calc(1 / 6 * 100%);
}
@media (max-width: 768px) {
    #mainDiv {
        margin-left: 0;
    }
}
</style>
